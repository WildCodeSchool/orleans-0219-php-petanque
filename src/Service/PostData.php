<?php
namespace App\Service ;

/**
 * Generic class of postdata controlling
 * Class PostData
 * @package App\Service
 */
class PostData
{
    private $postDatas;

    /**
     * PostData constructor.
     * @param array $datas
     */
    public function __construct(array $datas)
    {
        $this->postDatas = $datas;
    }

    /**
     * @return array
     */
    public function getPostDatas(): array
    {
        return $this->postDatas;
    }

    /**
     * @param array $postDatas
     */
    public function setPostDatas(array $postDatas): void
    {
        $this->postDatas = $postDatas;
    }

    /**
     * Clean all data from postdata to an array
     *
     * @return array
     */
    public function cleanValues(): array
    {
        $dataArray=[];
        foreach ($this->postDatas as $keyArray => $valueArray) {
            $data= $valueArray;
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = strip_tags($data);

            $dataArray[$keyArray] = $data;
        }

        return $dataArray;
    }
}
