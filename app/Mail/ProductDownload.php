<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Log;

use App\Nuvemshop;
use App\EmailTemplate;

class ProductDownload extends Mailable
{
	use Queueable, SerializesModels;

	public $nuvemShop;
	public $params;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($nuvemShop, $params)
	{
		$this->nuvemShop = $nuvemShop;
		$this->params = $params;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		if($this->nuvemShop->emailTemplate) {

			//Get the template
			$template = $this->nuvemShop->emailTemplate;

			// Set Recipient Name
			$content = str_replace('[RecipientName]', $this->params['recipientName'], $template->content);

			// Set Download Links
			$str_download = '<ul>';

			foreach ($this->params['downloadLinks'] as $link) {
				$str_download .= '<li>';

				$str_download .= '<a href="' . $link . '" title="">' . $link . '</a>';

				$str_download .= '</li>';
			}

			$str_download .= '</ul>';

			$content = str_replace('[DownloadLinks]', $str_download, $content);

			// Send mail
			return $this->from($template->from_address, $template->from_name)
						->subject($template->subject)
						->view('emails.product.custom')
						->with([
							'header' => $template->header,
							'content' => $content,
							'footer' => $template->footer,
						]);
		}
		else {
			// Send mail
			return $this->markdown('emails.product.download')
						->with([
							'downloadLinks' => $this->params['downloadLinks'],
							'recipientName' => $this->params['recipientName'],
						]);	
		}
	}
}
