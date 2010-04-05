<?php

class Application_Model_Search
{
    
    private $indexPath;
    function __construct(){
        $this->indexPath = APPLICATION_PATH . '/data/searchindex';
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(
            new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
    }
    
    public function createIndex(){
        $index = Zend_Search_Lucene::create($this->indexPath);
    }
    
    public function updateIndex(){
        $index = Zend_Search_Lucene::open($this->indexPath);
        
        $beverages = new Application_Model_BeveragesMapper();
        $searchDocs = $beverages->fetchAllSearchDocs();
        foreach ($searchDocs as $searchDoc){
            $doc = $this->createLuceneDoc($searchDoc);
            $index->addDocument($doc);
        }
        
        $index->optimize();
        
    }
    
    public function search($string){
        try {
            $index = Zend_Search_Lucene::open($this->indexPath);
        } catch (Zend_Search_Exception $e) {
            echo "Ошибка: {$e->getMessage()}";
        }
        
        $query = Zend_Search_Lucene_Search_QueryParser::parse($string, 'utf-8');
        return $index->find($query);
    }
    
    public function createLuceneDoc(Application_Model_SearchDoc $hit){
            $doc = new Zend_Search_Lucene_Document();
            
            $doc->addField(Zend_Search_Lucene_Field::Text('title', $hit->title, 'utf-8'));
            $doc->addField(Zend_Search_Lucene_Field::Text('content', $hit->content, 'utf-8'));
            $doc->addField(Zend_Search_Lucene_Field::UnIndexed('type', $hit->type, 'utf-8'));
            $doc->addField(Zend_Search_Lucene_Field::UnIndexed('id', $hit->id));
            
            return $doc; 
        
    }
}

