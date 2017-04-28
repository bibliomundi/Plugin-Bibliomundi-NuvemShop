<?php

namespace App;

class Product
{
	public $bbmProduct; //Object Parser
	public $lang; //Default language
    public $id; //The unique numeric identifier for the Product
    public $name; //List of the names of the Product, in every language supported by the store
    public $description; //List of the descriptions of the Product, as HTML, in every language supported by the store
    // public $handle; //List of the url-friendly strings generated from the Product's names, in every language supported by the store
    public $variants; //List of Product Variant objects representing the different version of the Product
    public $images; //List of Product Image objects representing the Product's images
    public $categories; //List of Category objects representing the Product's categories
    public $published; //true if the Product is published in the store. false if the Product will not show up on the store
    public $attributes; //List of the names of the attributes whose values define the variants. E.g.: Color, Size, etc.
    // public $tags; //String with all the Product's tags, separated by commas
    public $created_at;	//Date when the Product was created in ISO 8601 format
    public $updated_at; //Date when the Product was last updated in ISO 8601 format

    public function __construct($bbmProduct)
    {
    	$this->bbmProduct = $bbmProduct;
    	$this->lang = 'pt';
    	$this->published = true;
        // $this->free_shipping = true;

    	$this->setName($this->getName());
    	$this->setDescription($this->getDescription());
    	$this->setImages($this->getImages());    
    	$this->setVariants($this->getVariants());
    	// $this->setAttributes($this->getAttributes());

    	//remove
    	unset($this->bbmProduct);
    	unset($this->lang);

    	return $this;
    }

    public function setID($id)
    {
    	$this->id = $id;
    }

    public function getName()
    {
    	return [$this->lang => $this->bbmProduct->getTitle()];
    }

    public function setName($name)
    {
    	$this->name = $name;
    }

    public function getDescription()
    {
        $autorsName = implode(',', array_map(array('\BBMParser\Model\Contributor', 'getFullNameStatically'), $this->bbmProduct->getContributorsByType('Autor')));
        $ilustradorsName = implode(',', array_map(array('\BBMParser\Model\Contributor', 'getFullNameStatically'), $this->bbmProduct->getContributorsByType('Ilustrador')));

        $str = [
            'ISBN : '.$this->bbmProduct->getISBN(),
            'Editora : '.$this->bbmProduct->getImprintName(),
            'Formato : '.$this->bbmProduct->getFormatType(),
            'Edição : '.$this->bbmProduct->getEditionNumber(),
            'Proteção : '.$this->bbmProduct->getProtectionType(),
            'Idioma : '.$this->bbmProduct->getIdiom(),
            'Número de Páginas : '.$this->bbmProduct->getPageNumbers(),
            'Faixa Etária : '.$this->bbmProduct->getAgeRatingValue(),
            'Coleção : '.$this->bbmProduct->getCollectionTitle()        
        ];
        if($autorsName)
            $str[] = 'Autor : '.$autorsName;
        if($ilustradorsName)
            $str[] = 'Ilustrador : '.$ilustradorsName;
        if($this->bbmProduct->getSynopsis())
            array_unshift($str , 'Description : '.$this->bbmProduct->getSynopsis());

    	return [$this->lang => implode("<br />", $str)];
    }

    public function setDescription($description)
    {
    	$this->description = $description;
    }

    public function getVariants()
    {
    	$prices = $this->bbmProduct->getPrices();
    	$variants = [];
    	foreach ($prices as $price) {
    		if($price->getCurrency() == 'BRL'){
    			$variants['price'] = $price->getAmount();
    			break;    	
    		}
    	}
    	$variants['stock_management'] = false;
    	$variants['stock']  = null;
    	$variants['depth']  = null;
        $variants['height'] = null;

    	return $variants;
    }

    public function setVariants($variants)
    {
    	$this->variants[0] = $variants;
    }

    public function getImages()
    {
        if(!empty(getimagesize('http://'.$this->bbmProduct->getUrlFile() ))){
            return ['src' => 'http://'.$this->bbmProduct->getUrlFile()];
        }else{
            // sample image in case testing without a real image
            return ['src' => 'https://avatars0.githubusercontent.com/u/12715450?v=3&s=400'];
        }
    }

    public function setImages($image)
    {
    	$this->images[] = $image;
    }

    public function getAttributes()
    {
    	$attributes[] = [$this->lang => 'Feature'];  
    	return $attributes;
    }

    public function setAttributes($attributes)
    {
    	$this->attributes = $attributes;
    }
}
