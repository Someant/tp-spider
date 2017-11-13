<?php
namespace Spider\Crawler;


class DouBanSpider extends Request
{

    public function getUrlMapByCategory($category_id)
    {
        $url = 'https://movie.douban.com/j/new_search_subjects?sort=T&range=0,10&tags={category_name},%E7%94%B5%E5%BD%B1&start={start_num}';
        $response = $this->getRequest($url);
        $data = json_decode($response,true);
        if (empty($data['data'])){
            return [];
        }
        foreach ($data['data'] as $item){
            $list[] = [
                'outside_id' => $item['id'],
                'rate' => (float)$item['rate'],
                'category_id' => $category_id,
                'title' => $item['title'],
                'directors' => implode(',',$item['directors']),
                'casts' => implode(',',$item['casts']),
                'cover_orgin' => $item['cover'],
            ];
        }
        return $list;
    }

}