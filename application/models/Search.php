<?php
/**
 * Класс поиска. 
 */
class Application_Model_Search
{
    // путь к индексу
    private $indexPath;
    // индекс
    private $sIndex;
    
    /**
     * конструктор. определяет поисковый индекс ($this->sIndex).
     * если он не создан, то сначала создаёт его 
     */
    function __construct()
    {
        $this->indexPath = APPLICATION_PATH . '/data/searchindex';
        
        Zend_Search_Lucene_Analysis_Analyzer::setDefault(
            new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
        
        try{
            // пытаемся открыть индекс
            $this->sIndex = Zend_Search_Lucene::open($this->indexPath);
            
        } catch(Zend_Search_Lucene_Exception $e) {
            // если не получалось, то создаём и обновляем
            Zend_Search_Lucene::create($this->indexPath);
            $this->sIndex = Zend_Search_Lucene::open($this->indexPath);
            
            // плохо, это нужно было вынести, но так мы избавляемся
            // от необходимости инсталяции приложения (индекс,
            // если он отсутствует создастся на лету)
            $beverages = new Application_Model_BeveragesMapper();
            $searchDocs = $beverages->fetchAllSearchDocs();
            
            // добавляем все документы в индекс
            foreach ($searchDocs as $searchDoc){
                $doc = $this->createLuceneDoc($searchDoc);
                $this->sIndex->addDocument($doc);
            }
            $index->optimize();
        }
    }
    
    /**
     * добавляет документ к индексу
     *
     * @param Application_Model_SearchDoc $searchDoc
     *
     */
    public function addToIndex(Application_Model_SearchDoc $searchDoc)
    {
        $doc = $this->createLuceneDoc($searchDoc);
        $this->sIndex->addDocument($doc);
    }
    
    /**
     * обновляет документ в индексе
     *
     * @param Application_Model_SearchDoc $searchDoc
     *
     */
    public function updateInIndex(Application_Model_SearchDoc $searchDoc)
    {
        $this->deleteFromIndex($searchDoc);
        $doc = $this->createLuceneDoc($searchDoc);
        $this->sIndex->addDocument($doc);
    }
    
    /**
     * удаляет документ из индекса
     *
     * @param Application_Model_SearchDoc $searchDoc
     *
     */
    public function deleteFromIndex(Application_Model_SearchDoc $searchDoc)
    {
        $hits = $this->sIndex->find('docid:' . $searchDoc->id);
        foreach ($hits as $hit) {
            $this->sIndex->delete($hit->id);
        }
    }
    
    /**
     * ищет строку в индексе
     *
     * @param Application_Model_SearchDoc $searchDoc
     * @return Zend_Search_Lucene_Document
     */
    public function search($string)
    {
        $query = Zend_Search_Lucene_Search_QueryParser::parse($string, 'utf-8');
        return $this->sIndex->find($query);
    }
    
    /**
     * создаёет LuceneDoc из SearchDoc
     *
     * @param Application_Model_SearchDoc $searchDoc
     * @return Zend_Search_Lucene_Document
     */
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

