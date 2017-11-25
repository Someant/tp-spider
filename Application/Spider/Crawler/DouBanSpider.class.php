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

    public function getShortComment($outside_id)
    {
        $url = 'https://movie.douban.com/subject/{outside_id}/comments?start=0&limit=20&sort=new_score&status=P&percent_type=';
        $response = $this->getRequest($url);
        \phpQuery::newDocument($response);

        foreach (pq('#comments .comment-item') as $item){
            $p_url = pq($item)->find('.avatar a')->attr('href');
            $rate = pq($item)->find('.comment-info .rating')->attr('class');
            $data[] = [
                'outside_id' => $outside_id,
                'pid' => explode('/',$p_url)[4],
                'content' => trim(pq($item)->find('.comment>p')->text()),
                'votes' => intval(pq($item)->find('.comment-vote .votes')->text()),
                'rate' => mb_substr($rate,7,2),
                'public_date' => pq($item)->find('.comment-info .comment-time ')->attr('title'),
            ];
        }

        return $data;
    }

}