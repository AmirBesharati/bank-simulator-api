<?php

namespace App\QueryBuilders;

use App\QueryBuilders\Helpers\UrlHelper;
use App\QueryBuilders\Helpers\UrlQueryStringMaker;
use App\QueryBuilders\Paginator\Pagination;
use App\QueryBuilders\Paginator\PaginationItem;
use function url;

abstract class BaseBuilder
{
    private $page = 1;
    private $per_page = 20;
    protected $orderByDirection = 'DESC';
    protected $orderByColumn = 'id';
    private $start_url_with = '';
    private $anchor_in_url = null;
    private $starter_query = null;
    private $get_count_of_all_holder = 0;
    private $with = null;


    public function setWith(array $with)
    {
        $this->with = $with;
        return $this;
    }

    /**
     * @return null
     */
    public function getWith()
    {
        return $this->with;
    }

    /**
     * @return string
     */
    public function getOrderByDirection(): string
    {
        return $this->orderByDirection;
    }

    /**
     * @param string $orderByDirection
     */
    public function setOrderByDirection(string $orderByDirection)
    {
        $this->orderByDirection = $orderByDirection;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderByColumn(): string
    {
        return $this->orderByColumn;
    }

    /**
     * @param string $orderByColumn
     */
    public function setOrderByColumn(string $orderByColumn)
    {
        $this->orderByColumn = $orderByColumn;
        return $this;
    }


    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page if this parameter is null or negative set it to 1
     */
    public function setPage($page)
    {
        if ($page == null || $page <= 0) {
            $this->page = 1;
        } else {
            $this->page = $page;
        }
        return $this;
    }


    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * @param int $per_page
     */
    public function setPerPage($per_page)
    {
        $this->per_page = $per_page;
        return $this;
    }

    /**
     * @return string
     */
    public function getStartUrlWith()
    {
        return $this->start_url_with;
    }

    /**
     * @param string $start_url_with add / to first of parameter and remove / from end of parameter
     */
    public function setStartUrlWith($start_url_with)
    {
        $this->start_url_with = UrlHelper::AddSlashesToBaseUrl($start_url_with);
        return $this;
    }

    /**
     * @return null
     */
    public function getAnchorInUrl()
    {
        return $this->anchor_in_url;
    }

    /**
     * @param null $anchor_in_url
     */
    public function setAnchorInUrl($anchor_in_url)
    {
        $this->anchor_in_url = $anchor_in_url;
        return $this;
    }

    /**
     * @return null
     */
    public function getStarterQuery()
    {
        return $this->starter_query;
    }

    /**
     * @param null $starter_query
     */
    public function setStarterQuery($starter_query)
    {
        $this->starter_query = $starter_query;
        return $this;
    }

    public function getCountOfAll()
    {
        if ($this->get_count_of_all_holder !== null) {
            return $this->get_count_of_all_holder;
        }
        $query = $this->getQueryBuilder();

        $this->get_count_of_all_holder = $query->count();
        return $this->get_count_of_all_holder;
    }


    /**
     * return pagination array
     * @param $absolute bool
     * @return array array of PaginationItem
     */
    public function getPaginationLinks($absolute = false)
    {
        $paging = $this->getPaginationObject();
        $links = $paging->get_PaginationArray();
        $new_filter = clone $this;
        $urlArray = [];
        $prevPage = $paging->get_prev_page();
        $page_url = "";
        if ($prevPage > 0) {
            $new_filter->setPage($prevPage);
            $page_url = $new_filter->getUrlFromThisObject();
            if ($absolute) {
                $page_url = url($page_url);
            }
            $pagination_item = new PaginationItem($prevPage, $page_url, PaginationItem::PAGE_TYPE_PREV);
            $urlArray[] = $pagination_item;
        }

        foreach ($links as $li) {
            $new_filter->setPage($li);
            //$li==$this->jobalert_user_filter_->getPage())?'current':'';
            $page_url = $new_filter->getUrlFromThisObject();

            if ($absolute) {
                $page_url = url($page_url);
            }
            if ($li == $this->getPage()) {
                $pagination_item = new PaginationItem($li, $page_url, PaginationItem::PAGE_TYPE_CURRENT);
            } else {
                $pagination_item = new PaginationItem($li, $page_url);
            }
            $urlArray[] = $pagination_item;
        }


        $nextPage = $paging->get_next_page();
        if ($nextPage > 0) {
            $new_filter->setPage($nextPage);
            $page_url = $new_filter->getUrlFromThisObject();
            if ($absolute) {
                $page_url = url($page_url);
            }
            $pagination_item = new PaginationItem($nextPage, $page_url, PaginationItem::PAGE_TYPE_NEXT);
            $urlArray[] = $pagination_item;
        }
        return $urlArray;

    }


    /**
     * return url with default url builder object
     * @return string base url
     */
    public function getUrlFromThisObject()
    {
        $final_url = $this->getStartUrlWith();
        $url_builder = $this->getDefaultUrlBuilder();

        return $url_builder->get_url_with_query_string($final_url);

    }


    /**
     * Return default UrlQueryStringMaker object <br>
     * It is better to override this method
     * @return UrlQueryStringMaker
     */
    protected function getDefaultUrlBuilder()
    {
        $url_builder = new UrlQueryStringMaker();
        //if ($this->getPage()!=null and $this->getPage()>1){
        if ($this->getPage() != null) {
            $url_builder->add_to_first('page', $this->getPage());
        }

        return $url_builder;

    }


    /**
     * Return pagination Object associated with this object
     */
    public function getPaginationObject()
    {

        $paging = new Pagination();
        $paging->setCurrentPage($this->getPage());
        $paging->setNumberOfLinks(20);
        $paging->setRecordsPerPage($this->getPerPage());
        $paging->setTotalRecords($this->getCountOfAll());

        return $paging;
    }

    public function getPageCount()
    {
        $paging = $this->getPaginationObject();
        return $paging->get_page_count();
    }

    public function makeObjectFromRequest(\Illuminate\Http\Request $request)
    {
        $this->setPage($request->get('page'));
        $this->setPerPage($request->get('perPage'));
        return $this;
    }


    public function hasNextPage()
    {
        return $this->getPageCount() > $this->getPage();
    }

    /**
     * return html string for next and prev meta
     * @return string
     */
    public function getPrevNextMetaHtmlView()
    {
        $links = $this->getPaginationLinks(true);
        $str_links = '';
        foreach ($links as $link) {
            if ($link->getPageType() == PaginationItem::PAGE_TYPE_PREV) {
                $url = $link->getUrl();
                $str_links .= "<link rel=\"prev\" href=\"$url\" />";
            } elseif ($link->getPageType() == PaginationItem::PAGE_TYPE_NEXT) {
                $url = $link->getUrl();
                $str_links .= "<link rel=\"next\" href=\"$url\" />";
            }
        }
        return $str_links;
    }

    /**
     * Get a table_name and Return true if this table already exists in joins
     * @param $table_name string
     * @return bool
     */
    public function hasJoin($table_name)
    {

        $joins = $this->getQueryBuilder()->getQuery()->joins;
        if ($joins == null) {
            return false;
        }
        foreach ($joins as $join) {
            if ($join->table == $table_name) {
                return true;
            }
        }
        return false;

    }

    public function getPureSql()
    {
        $sql = $this->getQueryBuilder()->toSql();
        $binds = $this->getQueryBuilder()->getBindings();

        $result = "";

        $sql_chunks = explode('?', $sql);

        foreach ($sql_chunks as $key => $sql_chunk) {
            if (isset($binds[$key])) {
                $result .= $sql_chunk . '"' . $binds[$key] . '"';
            }
        }

        $result = $result . $sql_chunks[sizeof($sql_chunks) - 1];

        return $result;
    }

    /**
     * return result by adding pagination query to this objects query
     * @return mixed
     */
    public function getResult($with_pagination = false)
    {
        $query = $this->getQueryBuilder();

        if ($with_pagination) {
            return $query->paginate($this->getPerPage());
        }

        return $query->get();


    }

    abstract public function getQueryBuilder();
}
