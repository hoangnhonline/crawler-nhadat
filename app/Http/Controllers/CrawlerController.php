<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Goutte, File, Auth;
use App\Helpers\simple_html_dom;
use App\Helpers\Helper;
use App\Models\CrawlData;

class CrawlerController extends Controller
{    
    public function crawler(){
        set_time_limit(10000);
        /* muaban.net */ 
        $arrMuaBan = [
            '1' => 'https://muaban.net/nha-mat-tien-ho-chi-minh-l59-c3201?cp=',
            '1' => 'https://muaban.net/nha-hem-ngo-ho-chi-minh-l59-c3202?cp=',
            '2' => 'https://muaban.net/nha-mat-tien-ho-chi-minh-l59-c3401?cp=',
            '2' => 'https://muaban.net/mat-bang-cua-hang-shop-ho-chi-minh-l59-c3403?cp=',
            '2' => 'https://muaban.net/nha-hem-ngo-ho-chi-minh-l59-c3407?cp='
        ];
        foreach($arrMuaBan as $type => $link_crawl){
            $limit = 10;

            for($page = $limit; $page >= 1; $page--){                   
                $arrReturn = [];
                $url = $link_crawl.$page;
               
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);            
               
                curl_close($ch);                
                $crawler = new simple_html_dom();                
                $crawler->load($result);                
                $i = 0;                
                $arrInsert = [];            
                foreach($crawler->find('div.mbn-box-list-content') as $element){
              
                    $href = $element->find('a', 0)->href;
                    $arr['tieu_de'] = trim($element->find('.mbn-title', 0)->plaintext);
                    $arr['gia'] = trim($element->find('.mbn-price', 0)->plaintext);
                    $arr['type'] = $type;
                    $rs = CrawlData::where('url',$href)->first();
                    if(!$rs){
                        $this->getDetailMuaBan($href, $arr);
                    }
                              
                 }
            }   

        }
        
        /* batdongsan.com.vn */
        
        $arrBds = [
            '1' => 'https://batdongsan.com.vn/ban-nha-rieng-tp-hcm/p',
            '1' => 'https://batdongsan.com.vn/ban-nha-mat-pho-tp-hcm/p',
            '2' => 'https://batdongsan.com.vn/cho-thue-nha-rieng-tp-hcm/p',
            '2' => 'https://batdongsan.com.vn/cho-thue-nha-mat-pho-tp-hcm/p',
            '2' => 'https://batdongsan.com.vn/cho-thue-kho-nha-xuong-dat-tp-hcm/p'
        ];
        foreach($arrBds as $type => $link_crawl){
            $limit = 10;

            for($page = $limit; $page >= 1; $page--){                     
                $arrReturn = [];
                $url = $link_crawl.$page;                                          
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);             
               
                curl_close($ch);                
                $crawler = new simple_html_dom();                
                $crawler->load($result);                
                $i = 0;                
                $arrInsert = [];
                $i=0;
                foreach($crawler->find('.Main div.search-productItem') as $element){
                    if($element->find('a', 0)){
                        $href = $element->find('a', 0)->href;
                        $arr['tieu_de'] = trim($element->find('.p-title h3', 0)->plaintext);
                        $arr['gia'] = trim($element->find('span.product-price', 0)->plaintext);
                        $arr['dien_tich'] = trim($element->find('span.product-area', 0)->plaintext);
                        $arr['type'] = $type;
                        $rs = CrawlData::where('url',$href)->first();
                        if(!$rs){                       
                            $this->getDetailBds("https://batdongsan.com.vn".$href, $arr);
                        }
                    }
                              
                 }
            }
        }    
          
        /* muabannhadat */
        
        $arrmuabannhadat = [
            '1' => 'http://www.muabannhadat.vn/nha-ban-nha-pho-3535/tp-ho-chi-minh-s59?p=',            
            '2' => 'http://www.muabannhadat.vn/nha-cho-thue-3518/tp-ho-chi-minh-s59?p=',
            '2' => 'http://www.muabannhadat.vn/mat-bang-cho-thue-3521/tp-ho-chi-minh-s59?p='
        ];
        foreach($arrmuabannhadat as $type => $link_crawl){
            $limit = 10;

            for($page = $limit; $page >= 1; $page--){                     
                $arrReturn = [];
                $url = $link_crawl.$page;
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);                
                $crawler = new simple_html_dom();                
                $crawler->load($result);                
                $i = 0;                
                $arrInsert = [];
                $i=0;
                foreach($crawler->find('.content-list div.Product-TopListing') as $element){
                    if($element->find('a', 0)){
                        $href = $element->find('a', 0)->href;
                        $rs = CrawlData::where('url',$href)->first();
                        $arr['tieu_de'] = trim($element->find('.title-filter-link', 0)->plaintext);
                        $arr['gia'] = trim($element->find('.listing-price', 0)->plaintext);                        
                        $arr['type'] = $type;
                        if(!$rs){                                
                            $this->getDetailMbnd("http://www.muabannhadat.vn".$href, $arr);
                        }
                    }
                              
                 }
            }
        } 
    
        /* nhadatnhanh */
        $arrnhadatnhanh = [
            '1' => 'https://nhadatnhanh.vn/dm-nha-ban-nha-pho-1/tt-tp.ho-chi-minh-1/page:',            
            '2' => 'https://nhadatnhanh.vn/dm-nha-cho-thue-nha-pho-17/tt-tp-ho-chi-minh-1/page:'
        ];
        foreach($arrnhadatnhanh as $type => $link_crawl){
            $limit = 10;

            for($page = $limit; $page >= 1; $page--){       
                $arrReturn = [];
                $url = $link_crawl.$page;                                       
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);             
               
                curl_close($ch);
                
                $crawler = new simple_html_dom();
                
                $crawler->load($result);
                    
                $i = 0;
                
                $arrInsert = [];
                $i=0;
                foreach($crawler->find('.result-list div.Product-Free') as $element){
                    if($element->find('a', 0)){
                        $href = $element->find('a', 0)->href;
                        $rs = CrawlData::where('url',$href)->first();
                        $arr['tieu_de'] = trim($element->find('.title h3', 0)->plaintext);
                        $arr['gia'] = trim($element->find('.listing-price span', 0)->plaintext); 
                        $tmp = $element->find('.line-des .col-xs-12', 0)->innertext;
                        if($tmp){
                            $tmp = explode('<img src="/img/svg/ic-acreage.svg" alt="NhaDatNhanh">', $tmp);
                            if(!empty($tmp) && isset($tmp[1])){
                                $arr['dien_tich'] = trim(str_replace("&nbsp;", "", $tmp[1]));
                            }
                        }              
                        $arr['type'] = $type;
                        if(!$rs){                                
                            $this->getDetailNhaDatNhanh("https://nhadatnhanh.vn/".$href, $arr);
                        }
                    }
                              
                 }                              
            }
        }  
          
    }
    public function getDetailMuaBan($url, $arrData){         
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
      //dd($result);
        curl_close($ch);
        // Create a DOM object
        $crawler = new simple_html_dom();
        // Load HTML from a string
        $crawler->load($result);
        //dd($crawler->find('#product-options-wrapper .option select', 0)->innertext);
        if($crawler->find('#dvContent .ct-contact', 0)){
            $select = $crawler->find('#dvContent .ct-contact', 0);
            $arrData['url'] = $url;
            $arrData['site_id'] = 1;            
            if($select->find('.col-md-2')){          
                foreach($select->find('.col-md-2') as $opt){                            
                    
                    $value = trim($opt->plaintext);
                    if($value == 'Điện thoại:'){
                        
                        $phone = trim($opt->next_sibling()->plaintext);
                        $arrData['phone'] = $phone != '' ? $phone : null;
                    }elseif($value == "Liên hệ:"){
                        $name = trim($opt->next_sibling()->plaintext);
                        $arrData['name'] = $name != '' ? $name : null;
                    }elseif($value == "Địa chỉ:"){
                        $address = trim($opt->next_sibling()->plaintext);
                        $arrData['address'] = $address != '' ? $address : null;
                    }
                    $this->insertDb($arrData);
                }                
            }
        }        
    }
    public function insertDb($arrData){
        if(isset($arrData['phone'])){
            if(!isset($arrData['address']) || $arrData['address'] == null){
                $arrData['moigioi'] = 1;
            }else{ // check coi dia chi do co bao nhieu so dien thoai
                $address = $arrData['address'];
                $phone = $arrData['phone'];
                $rsCheck = CrawlData::where('address', $address)->where('phone', '<>', $phone)->get()->count();
                if($rsCheck >= 2){
                    $arrData['moigioi'] = 1;
                }
            }
            $rsData = CrawlData::where('phone', $arrData['phone'])->first();            

            if($rsData){
                $solanlap = $rsData->lap + 1;
                if($solanlap > 2){
                    $rsData->moigioi = 1;
                }
                $rsData->lap = $solanlap;
                $rsData->save();
            }else{
                
                CrawlData::create($arrData);        
            }
        }
    }
    //https://nha.chotot.com/tp-ho-chi-minh/mua-ban-nha-dat
    public function chotot(){
        set_time_limit(10000);
        $limit = 10;

        for($page = $limit; $page >= 1; $page--){               
            $arrReturn = [];
              $url = "https://nha.chotot.com/tp-ho-chi-minh/mua-ban-nha-dat?page=".$page;
                    $ch = curl_init();
                    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
                    curl_setopt( $ch, CURLOPT_URL, $url );
                    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $result = curl_exec($ch);
                 // dd($result);
                   
                    curl_close($ch);
                    // Create a DOM object
                    $crawler = new simple_html_dom();
                    // Load HTML from a string
                    $crawler->load($result);
                    //dd($crawler);       
                    $i = 0;
                    //var_dump('<h1>', $page, "</h1>");
                    $arrInsert = [];
                    $i=0;
                    foreach($crawler->find('div._1Bf8SBxRaJEgrc1xvKtNdp li.WIWLLwjT8zgtCiXu_IiZ9') as $element){
                        if($element->find('a', 0)){
                            $href = $element->find('a', 0)->href;
                            $rs = CrawlData::where('url',$href)->first();
                            if(!$rs){
                                $this->getDetailChoTot("https://nha.chotot.com".$href);
                            }
                        }
                                  
                     }
                }
                
          
    } 
    public function getDetailChoTot($url){         
       $url = "https://nha.chotot.com/quan-go-vap/mua-ban-nha-dat/can-ban-nha-chinh-chu-4-7m-12m-44044767.htm";
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        dd($result);
        //"account_name":"([^"]+)"      
        preg_match("/sms:[0-9]*/", $result, $arrPhone);
        
        if(!empty($arrPhone)){
            $arrData['phone'] = str_replace("sms:", "", $arrPhone[0]);
        }
       
        preg_match('/"account_name":"([^"]+)"/', $result, $arrName);
        if(!empty($arrName) && isset($arrName[1])){
            $arrData['name'] = $arrName[1];
        }

        preg_match('/"address":"([^"]+)"/', $result, $arrAddress);
        
        if(!empty($arrAddress) && isset($arrAddress[1])){
            $arrData['address'] = $arrAddress[1];
        }
        dd($arrData);
        curl_close($ch);
        // Create a DOM object
        $crawler = new simple_html_dom();
        // Load HTML from a string
        $crawler->load($result);
        //dd($crawler->find('#product-options-wrapper .option select', 0)->innertext);
        foreach($crawler->find('._179MyRQo6QuqZW68nLiY8x') as $a){
            var_dump($a->innertext);
        }
        dd('123');
        if($crawler->find('._179MyRQo6QuqZW68nLiY8x', 0)){
            $select = $crawler->find('._179MyRQo6QuqZW68nLiY8x', 0);
            dd($select->innertext);
            $arrData['url'] = $url;
            $arrData['site_id'] = 2; // muaban.net 
            if($select->find('._1UhGio5AiiNwuF41hEhcV0', 0)){
                $arrData['name'] = $select->find('._1UhGio5AiiNwuF41hEhcV0', 0)->plaintext;

            }
            dd($arrData);
            if($select->find('.col-md-2')){          
                foreach($select->find('.col-md-2') as $opt){                            
                    
                    $value = trim($opt->plaintext);
                    if($value == 'Điện thoại:'){
                        $arrData['phone'] = trim($opt->next_sibling()->plaintext);
                    }elseif($value == "Liên hệ:"){
                        $arrData['name'] = trim($opt->next_sibling()->plaintext);
                    }elseif($value == "Địa chỉ:"){
                        $arrData['address'] = trim($opt->next_sibling()->plaintext);
                    }
                    $this->insertDb($arrData);
                }                
            }
        }
        
    }
    public function bds(){
        set_time_limit(10000);
        $limit = 10;

        for($page = $limit; $page >= 1; $page--){ 
                //$url = "http://bepducthanh.vn/bo-bep-gas-khuyen-mai-d4p".$page.".html";
            $arrReturn = [];
            $url = "https://batdongsan.com.vn/ban-nha-rieng-tp-hcm/p".$page;   

           // http://bepducthanh.vn/thiet-bi-nha-bep-d2.html                         
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
         // dd($result);
           
            curl_close($ch);
            // Create a DOM object
            $crawler = new simple_html_dom();
            // Load HTML from a string
            $crawler->load($result);
            //dd($crawler);       
            $i = 0;
            //var_dump('<h1>', $page, "</h1>");
            $arrInsert = [];
            $i=0;
            foreach($crawler->find('.Main div.search-productItem') as $element){
                if($element->find('a', 0)){
                    $href = $element->find('a', 0)->href;
                    $rs = CrawlData::where('url',$href)->first();
                    if(!$rs){                                
                        $this->getDetailBds("https://batdongsan.com.vn".$href);
                    }
                }
                          
             }
        }
                
          
    } 
    public function getDetailBds($url, $arrData){  
        $arrData['url'] = $url;      
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
      //dd($result);
        curl_close($ch);
        // Create a DOM object
        $crawler = new simple_html_dom();
        // Load HTML from a string
        $crawler->load($result);
        //dd($crawler->find('#product-options-wrapper .option select', 0)->innertext);
        if($crawler->find('#LeftMainContent__productDetail_contactName div', 1)){            
            $name = trim($crawler->find('#LeftMainContent__productDetail_contactName div', 1)->plaintext);
            $arrData['name'] = $name != '' ? $name : null;
        }
        if($crawler->find('#LeftMainContent__productDetail_contactMobile div', 1)){
            $phone =  trim($crawler->find('#LeftMainContent__productDetail_contactMobile div', 1)->plaintext);

            $arrData['phone'] = $phone != '' ? $phone : null;
        }
        if($crawler->find('#LeftMainContent__productDetail_frontEnd', 0)){
            $addressHtml = $crawler->find('#LeftMainContent__productDetail_frontEnd', 0)->prev_sibling();
            if($addressHtml->find('div.right', 0)){
                $address = trim($addressHtml->find('div.right', 0)->plaintext);
                $arrData['address'] = $address != '' ? $address : null;    
            }

        }
        $arrData['site_id'] = 2;

        $this->insertDb($arrData);
    }
    public function nhadatnhanh(){
        set_time_limit(10000);
        $limit = 10;

        for($page = $limit; $page >= 1; $page--){ 
                //$url = "http://bepducthanh.vn/bo-bep-gas-khuyen-mai-d4p".$page.".html";
            $arrReturn = [];
            $url = "https://nhadatnhanh.vn/dm-nha-ban-nha-pho-1/tt-tp.ho-chi-minh-1/page:".$page;   

           // http://bepducthanh.vn/thiet-bi-nha-bep-d2.html                         
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
         // dd($result);
           
            curl_close($ch);
            // Create a DOM object
            $crawler = new simple_html_dom();
            // Load HTML from a string
            $crawler->load($result);
            //dd($crawler);       
            $i = 0;
            //var_dump('<h1>', $page, "</h1>");
            $arrInsert = [];
            $i=0;
            foreach($crawler->find('.result-list div.Product-Free') as $element){
                if($element->find('a', 0)){
                    $href = $element->find('a', 0)->href;
                    $rs = CrawlData::where('url',$href)->first();
                    if(!$rs){                                
                        $this->getDetailNhaDatNhanh("https://nhadatnhanh.vn/".$href);
                    }
                }
                          
             }
        }
                
          
    } 
    public function getDetailNhaDatNhanh($url, $arrData){        
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        
        curl_close($ch);
        // Create a DOM object
        $crawler = new simple_html_dom();
        // Load HTML from a string
        $crawler->load($result);

        //get id
        $tmp = explode("-", $url);
        $id = str_replace(".html", "", end($tmp));
        $arrData['url'] = $url;
        $phone = $this->getPhoneNhaDatNhanh($id);
        $arrData['phone'] = $phone != '' ? $phone : null;  
        //get phone
        //dd($crawler->find('#product-options-wrapper .option select', 0)->innertext);
        if($crawler->find('.box-contact .name-contact', 0)){            
            $name = trim($crawler->find('.box-contact .name-contact', 0)->plaintext);
            $arrData['name'] = $name != '' ? $name : null;  
        }
        if($crawler->find('.address-advert span', 0)){
            $address = trim($crawler->find('.address-advert span', 0)->plaintext);
            $arrData['address'] = $address != '' ? $address : null;              
        }
        $arrData['site_id'] = 4;  

        $this->insertDb($arrData);
    }

    public function tuoitre(){
        set_time_limit(10000);
        $limit = 4;

        for($page = $limit; $page >= 1; $page--){ 
                //$url = "http://bepducthanh.vn/bo-bep-gas-khuyen-mai-d4p".$page.".html";
            $arrReturn = [];
              $url = "http://batdongsantuoitre.vn/bds-ban/ban-nha-19&p=".$page;   

                   // http://bepducthanh.vn/thiet-bi-nha-bep-d2.html                         
                    $ch = curl_init();
                    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
                    curl_setopt( $ch, CURLOPT_URL, $url );
                    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $result = curl_exec($ch);
                 // dd($result);
                   
                    curl_close($ch);
                    // Create a DOM object
                    $crawler = new simple_html_dom();
                    // Load HTML from a string
                    $crawler->load($result);
                    //dd($crawler);       
                    $i = 0;
                    //var_dump('<h1>', $page, "</h1>");
                    $arrInsert = [];
                    $i=0;
                    foreach($crawler->find('#main_content div.itredd2') as $element){
                        if($element->find('a', 0)){
                            $href = $element->find('a', 0)->href;
                            $rs = CrawlData::where('url',$href)->first();
                            if(!$rs){                                
                                $this->getDetailTuoiTre("http://batdongsantuoitre.vn/".$href);
                            }
                        }
                                  
                     }
                }
                
          
    } 
    public function getDetailTuoiTre($url){ 
        dd($url);
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        
        curl_close($ch);
        // Create a DOM object
        $crawler = new simple_html_dom();
        // Load HTML from a string
        $crawler->load($result);

        //get id
        $tmp = explode("-", $url);
        $id = end($tmp);
        $arrData['url'] = $url;
        $arrData['phone'] = $this->getPhoneMbnd($id);
        //get phone
        //dd($crawler->find('#product-options-wrapper .option select', 0)->innertext);
        if($crawler->find('.detail-contact div.name-contact', 0)){            
            $arrData['name'] = trim($crawler->find('.detail-contact div.name-contact', 0)->plaintext);
        }
        if($crawler->find('#MainContent_ctlDetailBox_lblStreet', 0)){
            
            $address = trim($crawler->find('#MainContent_ctlDetailBox_lblStreet', 0)->plaintext);

        }
        $arrData['site_id'] = 3;

        $this->insertDb($arrData);
    }
    public function mbnd(){
        set_time_limit(10000);
        $limit = 10;

        for($page = $limit; $page >= 1; $page--){ 
                //$url = "http://bepducthanh.vn/bo-bep-gas-khuyen-mai-d4p".$page.".html";
            $arrReturn = [];
            $url = "http://www.muabannhadat.vn/nha-ban-nha-pho-3535/tp-ho-chi-minh-s59?p=".$page;   

           // http://bepducthanh.vn/thiet-bi-nha-bep-d2.html                         
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);
         // dd($result);
           
            curl_close($ch);
            // Create a DOM object
            $crawler = new simple_html_dom();
            // Load HTML from a string
            $crawler->load($result);
            //dd($crawler);       
            $i = 0;
            //var_dump('<h1>', $page, "</h1>");
            $arrInsert = [];
            $i=0;
            foreach($crawler->find('.content-list div.Product-TopListing') as $element){
                if($element->find('a', 0)){
                    $href = $element->find('a', 0)->href;
                    $rs = CrawlData::where('url',$href)->first();
                    if(!$rs){                                
                        $this->getDetailMbnd("http://www.muabannhadat.vn".$href);
                    }
                }
                          
             }
        }
                
          
    } 
    public function getDetailMbnd($url, $arrData){ 
 
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        
        curl_close($ch);
        // Create a DOM object
        $crawler = new simple_html_dom();
        // Load HTML from a string
        $crawler->load($result);

        //get id
        $tmp = explode("-", $url);
        $id = end($tmp);
        $arrData['url'] = $url;
        $arrData['phone'] = $this->getPhoneMbnd($id);
        //get phone
        //dd($crawler->find('#product-options-wrapper .option select', 0)->innertext);
        if($crawler->find('.detail-contact div.name-contact', 0)){            
            $name = trim($crawler->find('.detail-contact div.name-contact', 0)->plaintext);
            $arrData['name'] = $name != '' ? $name : null; 
        }
        if($crawler->find('#MainContent_ctlDetailBox_lblStreet', 0)){
            
            $address = trim($crawler->find('#MainContent_ctlDetailBox_lblStreet', 0)->plaintext);
             $arrData['address'] = $address != '' ? $address : null; 

        }
        if($crawler->find('#MainContent_ctlDetailBox_lblSurface', 0)){
            
            $dien_tich = trim($crawler->find('#MainContent_ctlDetailBox_lblSurface', 0)->plaintext);
             $arrData['dien_tich'] = $dien_tich != '' ? $dien_tich : null; 

        }
        $arrData['site_id'] = 3;

        $this->insertDb($arrData);
    }
    public function getPhoneMbnd($id){
        $phone = '';
        $ch2 = curl_init();
        //curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36" );
        curl_setopt($ch2, CURLOPT_URL,"http://www.muabannhadat.vn/Services/Tracking/a".$id."/GetPhoneCustom");
        curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Length: 0'));   
        curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, true );
       // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch2, CURLOPT_REFERER, 'http://www.muabannhadat.vn');
        

        $server_output = curl_exec ($ch2);
        
        curl_close ($ch2);
        $phone = str_replace('"', "", $server_output); 
        return $phone;
    }
    public function getPhoneNhaDatNhanh($id){
        $phone = '';
        
        $ch2 = curl_init();
        curl_setopt( $ch2, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36" );
        curl_setopt($ch2, CURLOPT_URL,"https://nhadatnhanh.vn/home/showphone");
        curl_setopt($ch2, CURLOPT_POST, 1);
        curl_setopt($ch2, CURLOPT_POSTFIELDS,
            "action=ajax&nhadat_id=".$id);
        //curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Length: 0'));   
        curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch2, CURLOPT_REFERER, 'https://nhadatnhanh.vn');
        

        $server_output = curl_exec ($ch2);
        //dd($server_output);
        curl_close ($ch2);
        $tmp = json_decode($server_output, true);
        if(!empty($tmp)){
            $phone = $tmp['phone'];
        }
        return $phone;
    }
    public function muaban2(){
        set_time_limit(10000);
        $limit = 10;

        for($page = $limit; $page >= 1; $page--){ 
                //$url = "http://bepducthanh.vn/bo-bep-gas-khuyen-mai-d4p".$page.".html";
            $arrReturn = [];
          $url = "https://muaban.net/cho-thue-nha-dat-ho-chi-minh-l59-c34?cp=".$page;   

               // http://bepducthanh.vn/thiet-bi-nha-bep-d2.html                         
                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
                curl_setopt( $ch, CURLOPT_URL, $url );
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
             // dd($result);
               
                curl_close($ch);
                // Create a DOM object
                $crawler = new simple_html_dom();
                // Load HTML from a string
                $crawler->load($result);
                //dd($crawler);       
                $i = 0;
                //var_dump('<h1>', $page, "</h1>");
                $arrInsert = [];
                $i=0;
                foreach($crawler->find('div.mbn-box-list-content') as $element){
                    $href = $element->find('a', 0)->href;
                    $rs = CrawlData::where('url',$href)->first();
                    if(!$rs){
                        $i++;
                        echo $i."-".$href;
                        echo "<hr>";
                        CrawlData::create(['url' => $href]);
                    }
                              
                 }
            }
    }    
}
