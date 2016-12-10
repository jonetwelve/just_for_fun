<?php

class P2S{
    public function __construct($img, $chars = null){
        list($this->width, $this->height, $type, $attr) = getimagesize($img);

        $this->im = imagecreatefromjpeg($img);

        if(is_array($chars)){
            $this->chars = $chars;
        }else{
            $this->chars = array('M', '@', 'D', 'n', '+', '1', ',', ' ');
        }
        $this->colorCount = ceil(255 / count($this->chars));
    }

    /**
     * 获取某个点的颜色值
     */
    private function getColorInt($x, $y){
        $rgb = ImageColorAt($this->im, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

        $back = round(($r + $b + $g) / 3);
        return $back;
    }

    public function getString($file = null){
        $str = '';
        for($i = 0; $i < $this->height; $i++){
            for($j = 0; $j < $this->width; $j ++){
                $color_int = $this->getColorInt($j, $i) / $this->colorCount;
                $str .= $this->chars[$color_int];
            }
            $str .= "\n";
        }

        if(null == $file){
            echo $str;
        }else{
            file_put_contents($file, $str);
        }
    }
}

$i = new P2S('1.jpg');
$i->getString('1.txt');
