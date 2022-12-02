<?php
/**
 * Created by PhpStorm.
 * User: le marcelo
 * Date: 10/01/2017
 * Time: 19:03
 */

namespace Projet\Model;


class Paginator{
    
    public $urlPrecedent = "";
    public $urlSuivant = "";
    private $url = "";
    public $disabledPrecedent = " class='disabled'";
    public $disabledSuivant = " class='disabled'";
    private $params = [];
    private $param = [];
    private $pageCourante;
    private $nbrePages;
    private $translator;

    public function __construct($url,$pageCourante,$nbrePages,$params,$param){
        $this->translator = new Translator();
        $this->url = ROOT_URL.$url;
        $this->nbrePages = $nbrePages<1 ? 1 : $nbrePages;
        $this->pageCourante = $pageCourante<=$nbrePages ? $pageCourante : 1;
        $this->param = $param;
        $this->params = $params;
        unset($this->params[$url]);
        unset($this->param[$url]);
    }

    public function arrayToString($table){
        $val = "";
        $i = 0;
        if(count($table)>0){
            foreach ($table as $key=>$value) {
                $j = ($i>0)?"&":"?";
                $val .= $j.$key."=".$value;
                $i++;
            }
        }
        return $val;
    }

    public function paginateOne(){
        if($this->pageCourante==1&&$this->nbrePages>1){
            $this->disabledSuivant = "";
            $this->params['page'] = $this->pageCourante+1;
            $textPage = $this->arrayToString($this->params);
            $this->urlSuivant = " href='".$this->url.$textPage."'";
        }elseif($this->pageCourante < $this->nbrePages  && $this->pageCourante > 1){
            $this->disabledSuivant = "";
            $this->disabledPrecedent = "";
            $this->param['page'] = $this->pageCourante+1;
            $this->params['page'] = $this->pageCourante-1;
            if($this->pageCourante==2){
                unset($this->params['page']);
            }
            $textPage = $this->arrayToString($this->params);
            $textPages = $this->arrayToString($this->param);
            $this->urlSuivant = " href='".$this->url.$textPages."'";
            $this->urlPrecedent = " href='".$this->url.$textPage."'";
        }elseif ($this->pageCourante == $this->nbrePages && $this->pageCourante > 1){
            $this->disabledPrecedent = "";
            $this->params['page'] = $this->pageCourante-1;
            if($this->pageCourante==2){
                unset($this->params['page']);
            }
            $textPage = $this->arrayToString($this->params);
            $this->urlPrecedent = " href='".$this->url.$textPage."'";
        }
        $var = 'Page '.$this->pageCourante.' sur '.$this->nbrePages;
        $sol = $this->nbrePages > 1 ? $var.' pages':$var.' page';
        echo '<p class="small-text pull-left">
                <i>'.$sol.'</i>
            </p>
            <ul class="pager pull-right mar-no"><li'.$this->disabledPrecedent.'><a'.$this->urlPrecedent.'><i class="uk-icon-angle-double-left"></i> '.$this->translator->get('page.menu.precedent').'</a></li>
            <li'.$this->disabledSuivant.'><a'.$this->urlSuivant.'>'.$this->translator->get('page.menu.suivant').' <i class="uk-icon-angle-double-right"></i></a></li></ul>';
    }

    private function getLi($href,$val,$isActive){
        $active = $isActive?" class='active'":"";
        return '<li'.$active.'><a'.$href.'>'.$val.'</a></li>';
    }

    public function getHref($val){
        $this->params['page'] = $val;
        if($val==1){
            unset($this->params['page']);
        }
        $textPage = $this->arrayToString($this->params);
        return " href='".$this->url.$textPage."'";
    }

    private function getLiInForSyntax($val,$isActive){
        $urls = (!$isActive)?$this->getHref($val):"";
        return $this->getLi($urls,$val,$isActive);
    }

    private function getPointilles($val){
        $result = ($val==0)?'<li><span>...</span></li>':'';
        return $result;
    }
    
    public function paginateTwo(){
        $ulBegin = '<ul class="pagination pull-right">';
        $ulEnd = '</ul>';
        $disabledBegin = " class='disabled'";
        $disabledEnd = " class='disabled'";
        $urlBegin = "";
        $urlEnd = "";
        $content = "";
        $j = 0;
        $k = 0;
        if($this->pageCourante==1&&$this->nbrePages==1){
            $content .= $this->getLiInForSyntax($this->pageCourante,true);
        }elseif($this->pageCourante==1&&$this->nbrePages>1){
            $disabledEnd = "";
            $urlEnd = $this->getHref($this->pageCourante+1);
            $content .= $this->getLi("",$this->pageCourante,true);
            if($this->nbrePages < 10){
                for ($i=2;$i<=$this->nbrePages;$i++){
                    $content .= $this->getLiInForSyntax($i,false);
                }
            }elseif ($this->nbrePages > 9 && $this->nbrePages < 18){
                for ($i=2;$i<=$this->nbrePages;$i++){
                    if($i < 7){
                        $content .= $this->getLiInForSyntax($i,false);
                    }
                    if($i > 6 && $i < $this->nbrePages-1){
                        $content .= $this->getPointilles($j);
                        $j++;
                    }
                    if($i > $this->nbrePages-2){
                        $content .= $this->getLiInForSyntax($i,false);
                    }
                }
            }else{
                for ($i=2;$i<=$this->nbrePages;$i++){
                    if($i < 7){
                        $content .= $this->getLiInForSyntax($i,false);
                    }
                    if($i > 6 && $i < $this->nbrePages-2){
                        $content .= $this->getPointilles($j);
                        $j++;
                    }
                    if($i > $this->nbrePages-3){
                        $content .= $this->getLiInForSyntax($i,false);
                    }
                }
            }
        }elseif($this->pageCourante < $this->nbrePages  && $this->pageCourante > 1){
            $disabledBegin = "";
            $disabledEnd = "";
            $urlBegin = $this->getHref($this->pageCourante-1);
            $urlEnd = $this->getHref($this->pageCourante+1);
            if($this->pageCourante < 5){
                if($this->nbrePages < 10){
                    for ($i=1;$i<=$this->nbrePages;$i++){
                        $content .= ($i==$this->pageCourante)?$this->getLiInForSyntax($i,true):$this->getLiInForSyntax($i,false);
                    }
                }else{
                    for ($i=1;$i<=$this->nbrePages;$i++){
                        if($i < 6){
                            $content .= ($i==$this->pageCourante)?$this->getLiInForSyntax($i,true):$this->getLiInForSyntax($i,false);
                        }
                        if($i > 5 && $i < $this->nbrePages-2){
                            $content .= $this->getPointilles($j);
                            $j++;
                        }
                        if($i > $this->nbrePages-3){
                            $content .= ($i==$this->pageCourante)?$this->getLiInForSyntax($i,true):$this->getLiInForSyntax($i,false);
                        }
                    }
                }
            }else{
                if($this->nbrePages < $this->pageCourante+5){
                    for ($i=1;$i<=$this->nbrePages;$i++){
                        if($i < 3){
                            $content .= $this->getLiInForSyntax($i,false);
                        }
                        if($i > 2 && $i < $this->pageCourante-1){
                            $content .= $this->getPointilles($j);
                            $j++;
                        }
                        if($i > $this->pageCourante-2){
                            $content .= ($i==$this->pageCourante)?$this->getLiInForSyntax($i,true):$this->getLiInForSyntax($i,false);
                        }
                    }
                }else{
                    for ($i=1;$i<=$this->nbrePages;$i++){
                        if($i < 3){
                            $content .= $this->getLiInForSyntax($i,false);
                        }
                        if($i > 2 && $i < $this->pageCourante-1){
                            $content .= $this->getPointilles($j);
                            $j++;
                        }
                        if($i > $this->pageCourante-2 && $i < $this->pageCourante+2){
                            $content .= ($i==$this->pageCourante)?$this->getLiInForSyntax($i,true):$this->getLiInForSyntax($i,false);
                        }
                        if($i > $this->pageCourante+1 && $i < $this->nbrePages-1){
                            $content .= $this->getPointilles($k);
                            $k++;
                        }
                        if($i > $this->nbrePages-2){
                            $content .= $this->getLiInForSyntax($i,false);
                        }
                    }
                }
            }
        }elseif ($this->pageCourante == $this->nbrePages && $this->pageCourante > 1){
            $disabledBegin = "";
            $urlBegin = $this->getHref($this->pageCourante-1);
            if($this->nbrePages < 10){
                for ($i=1;$i<=$this->nbrePages;$i++){
                    $content .= ($i==$this->pageCourante)?$this->getLiInForSyntax($i,true):$this->getLiInForSyntax($i,false);
                }
            }else{
                for ($i=1;$i<=$this->nbrePages;$i++){
                    if($i < 5){
                        $content .= $this->getLiInForSyntax($i,false);
                    }
                    if($i > 4 && $i < $this->nbrePages-3){
                        $content .= $this->getPointilles($j);
                        $j++;
                    }
                    if($i > $this->nbrePages-4){
                        $content .= ($i==$this->pageCourante)?$this->getLiInForSyntax($i,true):$this->getLiInForSyntax($i,false);
                    }
                }
            }
        }
        $liBegin = '<li'.$disabledBegin.'><a'.$urlBegin.'>‹</a></li>';
        $liEnd = '<li'.$disabledEnd.'><a'.$urlEnd.'>›</a></li>';
        echo $ulBegin.$liBegin.$content.$liEnd.$ulEnd;
    }

}