<?php
namespace App\Service ;

/**
 * Generic class of postdata controlling
 * Class PostData
 * @package App\Service
 */
class PostDatum
{
    private $postData;

    /**
     * PostDatum constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->postData = $data;
    }

    /**
     * @return array
     */
    public function getPostData(): array
    {
        return $this->postData;
    }

    /**
     * @param array $postData
     */
    public function setPostData(array $postData): void
    {
        $this->postData = $postData;
    }

    /**
     * Clean all data from postdata to an array
     *
     * @return array
     */
    public function cleanValues(): array
    {
        $dataArray=[];
        foreach ($this->postData as $keyArray => $valueArray) {
            $data= $valueArray;
            $data = trim($data);

            $dataArray[$keyArray] = $data;
        }

        return $dataArray;
    }
}
