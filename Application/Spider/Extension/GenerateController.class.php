<?php
namespace Spider\Extension;

use Think\Controller;

class GenerateController extends Controller
{
    /**
     * 生成Html表格
     * @param array $head
     * @param array $body
     * @return string
     */
    public function generateHtmlTable($head = array(), $body = array())
    {
        $html = '<table border="1" width="100%">';
        foreach ($head as $h) {
            $html .= '<td>' . $h . '</td>';
        }

        foreach ($body as $key => $value) {
            $html .= '<tr>';
            foreach ($value as $k => $v) {
                $html .= '<td>' . $v . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        return $html;
    }

    public static function fastGenerateHtmlTable($head = array(), $body = array())
    {
        return self::generateHtmlTable($head,$body);
    }
}