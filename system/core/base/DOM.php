<?php
/*
 * Title : DOM Controller
 * Description : Creates and manages DOM
 *
 */

// System Check
if (!defined("_WBCHAT_PLATFORM_")) throw new Exception("Web Platform is not defined!");

class DOM
{
	protected static $document;
	
	// Initialize document
	public static function initialize()
	{
		self::$document = new DOMDocument("1.0", "UTF-8");
	}
	
	// Creates and returns a domElement with the specified tagName and the specified attributes
	public static function create($tag = "div", $content = "", $id = "", $class = "")
	{
		$elem = self::$document->createElement($tag, $content);
		
		// Insert id if not null
		if (!is_null($id) && !empty($id))
			self::attr($elem, "id", $id);
			
		// Insert class if not null
		if (!is_null($class) && !empty($class))
			self::attr($elem, "class", $class);
		
		return $elem;
	}
	
	// Evaluate an XPath Query
	public static function evaluate($query, $context = NULL)
	{
		$xpath = new DOMXPath(self::$document);
		return $xpath->evaluate($query, $context);
	}
	
	// Find an element by id
	public static function find($id, $context = NULL)
	{
		$q = "//*[@id='$id']";
		$list = self::evaluate($q, $context);
		
		if ($list->length > 0)
			return $list->item(0);
			
		return NULL;
	}
	
	// Creates a specific comment tag
	public static function comment($content)
	{
		return self::$document->createComment($content);
	}
	
	// Imports a node to this document
	public static function import($node, $deep = TRUE)
	{
		if (is_null($node))
			return NULL;
		return self::$document->importNode($node, $deep);
	}
	
	// Returns the HTML form of the document
	public static function getHTML()
	{
		return self::$document->saveHTML();
	}
	
	// Returns the XML form of the document
	public static function getXML()
	{
		return self::$document->saveXML();
	}
	
	// Get the document
	public static function document()
	{
		return self::$document;
	}
	
	// Adds an attribute into a domElement
	public static function attr($elem, $name, $val = NULL)
	{
		// If value empty, return attribute value
		if (is_null($val))
			return $elem->getAttribute($name);
		
		// Trim attribute value
		$val = trim($val);
		
		// If val is empty, remove attribute	
		if (empty($val))
			return $elem->removeAttribute($name);
		
		// Check if id is valid
		if ($name == "id")
		{
			$match = preg_match("/^[a-zA-Z][\w\_\-\.\:]*$/i", $val);
			if (!$match)
				return $elem;
		}
		
		// Set attribute
		$elem->setAttribute($name, $val);
	}
	
	// Adds a series of attributes (in the form of an array) into a domElement
	public static function attrs($elem, $val = array())
	{
		if (is_array($val) && count($val) > 0)
			foreach ($val as $key=>$value)
				self::attr($elem, $key, $value);
	}
	
	// Appends the value of an attribute of a domElement
	public static function appendAttr($elem, $name, $val)
	{
		$val = trim($val);
		if (empty($val))
			return $elem;
		
		// Create new attribute value
		$old_val = $elem->getAttribute($name);
		$new_val = trim($old_val)." ".trim($val);
		
		// Set new attribute value
		self::attr($elem, $name, $new_val);
	}
	
	// Inserts data-[$name] attributes as an array into the domElement
	public static function data($elem, $name, $val = array())
	{
		if (is_array($val) && count($val) > 0)
		{
			$dta_attr = "{";
			foreach ($val as $key=>$value)
				if (!empty($value))
					$dta_attr .= "\"$key\":\"$value\",";
			$dta_attr .= "}";
			
			// Remove last comma
			$dta_attr = str_replace(",}", "}", $dta_attr);
			
			// Don't add anything if empty
			$dta_attr = str_replace("{}", "", $dta_attr);
			self::attr($elem, 'data-'.$name, $dta_attr);
		}
	}
	
	// Appends a DOMElement to a parent DOMElement
	public static function append($parent, $child = NULL)
	{
		if (is_null($child))
		{
			$document = $parent->ownerDocument;
			return $document->appendChild($parent);
		}
		
		if (is_null($parent))
			return;
			
		$parent->appendChild($child);
	}
	
	// Prepends a DOMElement to a parent DOMElement
	public static function prepend($parent, $child)
	{
		$parent->insertBefore($child, $parent->childNodes->item(0));
	}
	
	// Appends a DOMElement to a parent DOMElement, before the given child
	public static function appendBefore($parent, $before, $child)
	{
		if (is_null($child))
			return FALSE;
		$child->parentNode->insertBefore($before, $child);
	}
	
	// Replaces the old domElement with the new domElement
	public static function replace($old, $new)
	{
		if (is_null($old))
			return FALSE;
		
		// Remove
		if (is_null($new))
			return $old->parentNode->removeChild($old);
			
		// Replace
		return $old->parentNode->replaceChild($new, $old);
	}
	
	// Returns the nodeValue of the given domElement
	public static function nodeValue($element, $value = NULL)
	{
		if (is_null($value))
			return $element->nodeValue;
		
		$element->nodeValue = $value;
		return $element;
	}
	
	// Get or Set inner HTML
	public static function innerHTML($element, $value = NULL)
	{
		// If value is null, return inner HTML
		if (is_null($value))
		{
			$inner = "";
			foreach ($element->childNodes as $child)
				$inner .= $element->ownerDocument->saveXML($child);
	
			return $inner;
		}
		
		// If value not null, set inner HTML
		
		//____ Empty the element 
		for ($x=$element->childNodes->length-1; $x>=0; $x--)
			$element->removeChild($element->childNodes->item($x)); 

		//_____ $value holds our new inner HTML 
		if ($value == "")
			return FALSE;
		
		$f = $element->ownerDocument->createDocumentFragment(); 
		//_____ appendXML() expects well-formed markup (XHTML) 
		$result = @$f->appendXML($value);
		
		if ($result)
		{
			if ($f->hasChildNodes())
				$element->appendChild($f); 
		}
		else
		{
			$f = $element->ownerDocument;
			// $value is probably ill-formed 
			$value = mb_convert_encoding($value, 'HTML-ENTITIES', 'UTF-8');
			// Using <htmlfragment> will generate a warning, but so will bad HTML 
			// (and by this point, bad HTML is what we've got). 
			// We use it (and suppress the warning) because an HTML fragment will  
			// be wrapped around <html><body> tags which we don't really want to keep. 
			// Note: despite the warning, if loadHTML succeeds it will return true. 
			$result = @$f->loadHTML('<htmlfragment>'.$value.'</htmlfragment>'); 
			if ($result)
			{ 
				$import = $f->getElementsByTagName('htmlfragment')->item(0); 
				foreach ($import->childNodes as $child)
				{ 
					$importedNode = $element->ownerDocument->importNode($child, true); 
					$element->appendChild($importedNode); 
				} 
			}
		}
	}
}
?>