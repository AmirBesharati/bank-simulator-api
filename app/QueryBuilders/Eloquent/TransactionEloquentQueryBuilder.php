<?php

namespace App\QueryBuilders\Eloquent;
use App\Models\Transaction;
use App\QueryBuilders\BaseBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TransactionEloquentQueryBuilder extends BaseBuilder
{
    private $accountId = null;
    private $fromDate = null;
    private $toDate = null;
    private $transactionTypeId = null;
    private $side = null;

    /**
     * @return null
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param null $accountId
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
        return $this;
    }

    /**
     * @return null
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @param null $fromDate
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
        return $this;
    }

    /**
     * @return null
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @param null $toDate
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
        return $this;
    }

    /**
     * @return null
     */
    public function getTransactionTypeId()
    {
        return $this->transactionTypeId;
    }

    /**
     * @param null $transactionTypeId
     */
    public function setTransactionTypeId($transactionTypeId)
    {
        $this->transactionTypeId = $transactionTypeId;
        return $this;
    }

    /**
     * @return null
     */
    public function getSide()
    {
        return $this->side;
    }

    /**
     * @param null $side
     */
    public function setSide($side)
    {
        $this->side = $side;
        return $this;
    }


    public function makeObjectFromRequest(Request $request): TransactionEloquentQueryBuilder
    {
        parent::makeObjectFromRequest($request);

        if($request->get('account_id') != null){
            $this->setAccountId($request->get('account_id'));
        }

        if($request->get('from_date') != null){
            $this->setFromDate($request->get('from_date'));
        }

        if($request->get('to_date') != null){
            $this->setToDate($request->get('to_date'));
        }

        if($request->get('transaction_type_id') != null){
            $this->setTransactionTypeId($request->get('transaction_type_id'));
        }

        return $this;
    }



    public function getQueryBuilder(): Builder
    {
        $query = Transaction::query();

        if($this->getWith() != null){
            $query->with($this->getWith());
        }

        if(!is_null($this->getAccountId())){
            $query->where(function ($query){
                $query->orWhere('sender_account_id' , $this->getAccountId())->orWhere('receiver_account_id' , $this->getAccountId());
            });
        }
        if(!is_null($this->getFromDate())){
            $query->whereDate('created_at' , '>=' , $this->getFromDate());
        }
        if(!is_null($this->getToDate())){
            $query->whereDate('created_at' , '<=' , $this->getToDate());
        }
        if(!is_null($this->getTransactionTypeId())){
            $query->where('transaction_type_id' , $this->getTransactionTypeId());
        }

        $query->orderBy('id' , 'desc');


        return $query->selectRaw('transactions.*');
    }

}
