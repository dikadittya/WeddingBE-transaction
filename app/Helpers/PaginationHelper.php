<?php

namespace App\Helpers;


class PaginationHelper
{

    public static function cleanPaginationUrls($paginator)
    {
        $data = json_decode(json_encode($paginator), true);
        
        $data['first_page_url'] = self::removeBaseUrl($data['first_page_url']);
        $data['last_page_url'] = self::removeBaseUrl($data['last_page_url']);
        $data['next_page_url'] = self::removeBaseUrl($data['next_page_url']);
        $data['prev_page_url'] = self::removeBaseUrl($data['prev_page_url']);
        $data['path'] = '';
        
        foreach ($data['links'] as &$link) {
            $link['url'] = self::removeBaseUrl($link['url']);
        }
        
        return $data;
    }
    
    private static function removeBaseUrl($url)
    {
        if ($url === null) {
            return null;
        }
        // Remove base URL and path, keep only query parameters
        return preg_replace('/^https?:\/\/[^?]+/', '', $url);
    }
}
