<?php

class Application_Model_Search
{
    
    private $indexPath;
    
    function __construct()
    {
        $this->indexPath = APPLICATION_PATH . '/data/searchindex';
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(
            new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
    }
    
    public function createIndex()
    {
        $index = Zend_Search_Lucene::create($this->indexPath);
    }
    
    public function deleteIndex(){
        
    }
    
    public function updateIndex()
    {
        $index = Zend_Search_Lucene::open($this->indexPath);
        
        $beverages = new Application_Model_BeveragesMapper();
        $searchDocs = $beverages->fetchAllSearchDocs();
        foreach ($searchDocs as $searchDoc){
            $doc = $this->createLuceneDoc($searchDoc);
            $index->addDocument($doc);
        }
        
        $index->optimize();
    }
    
    public function addToIndex(Application_Model_SearchDoc $searchDoc)
    {
        $index = Zend_Search_Lucene::open($this->indexPath);
        $doc = $this->createLuceneDoc($searchDoc);
        $index->addDocument($doc);
    }
    
    public function updateInIndex(Application_Model_SearchDoc $searchDoc)
    {
        $index = Zend_Search_Lucene::open($this->indexPath);
        $hits = $index->find('docid:' . $searchDoc->id);
        foreach ($hits as $hit) {
            $index->delete($hit->id);
        }
        $doc = $this->createLuceneDoc($searchDoc);
        $index->addDocument($doc);
    }
    
    public function deleteFromIndex(Application_Model_SearchDoc $searchDoc)
    {
        $index = Zend_Search_Lucene::open($this->indexPath);
        $hits = $index->find('docid:' . $searchDoc->id);
        foreach ($hits as $hit) {
            $index->delete($hit->id);
        }
    }
    
    public function search($string)
    {
        $index = Zend_Search_Lucene::open($this->indexPath);
        
        $query = Zend_Search_Lucene_Search_QueryParser::parse($string, 'utf-8');
        return $index->find($query);
    }
    
    public function createLuceneDoc(Application_Model_SearchDoc $searchDoc)
    {
            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Text('title', $searchDoc->title, 'utf-8'));
            $doc->addField(Zend_Search_Lucene_Field::Text('content', $searchDoc->content, 'utf-8'));
            $doc->addField(Zend_Search_Lucene_Field::UnIndexed('type', $searchDoc->type, 'utf-8'));
            $doc->addField(Zend_Search_Lucene_Field::keyword('docid', $searchDoc->id));
            
            return $doc; 
        
    }
}

