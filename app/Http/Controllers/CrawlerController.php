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
    public function muaban(){
        set_time_limit(10000);
        $limit = 10;

        for($page = $limit; $page >= 1; $page--){ 
                //$url = "http://bepducthanh.vn/bo-bep-gas-khuyen-mai-d4p".$page.".html";
            $arrReturn = [];
            $url = "https://muaban.net/ban-nha-can-ho-ho-chi-minh-l59-c32?cp=".$page;   

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
            foreach($crawler->find('div.mbn-box-list-content') as $element){
          
                $href = $element->find('a', 0)->href;

                $rs = CrawlData::where('url',$href)->first();
                if(!$rs){
                    $this->getDetailMuaBan($href);

                }
                          
             }
        }            
          
    }
    public function getDetailMuaBan($url){         
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
            $arrData['site_id'] = 1; // muaban.net 
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
                    if(isset($arrData['phone'])){
                        $rsData = CrawlData::where('phone', $arrData['phone'])->first();
                        if($rsData){
                            $rsData->lap = $rsData->lap + 1;
                            $rsData->save();
                        }else{
                            CrawlData::create($arrData);        
                        }
                    }
                }                
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
                    if(isset($arrData['phone'])){
                        $rsData = CrawlData::where('phone', $arrData['phone'])->first();
                        if($rsData){
                            $rsData->lap = $rsData->lap + 1;
                            $rsData->save();
                        }else{
                            CrawlData::create($arrData);        
                        }
                    }
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
    public function getDetailBds($url){  
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

        if(isset($arrData['phone'])){
            $rsData = CrawlData::where('phone', $arrData['phone'])->first();
            if($rsData){
                $rsData->lap = $rsData->lap + 1;
                $rsData->save();
            }else{
                CrawlData::create($arrData);        
            }
        }
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
    public function getDetailNhaDatNhanh($url){        
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
        if(isset($arrData['phone'])){
            $rsData = CrawlData::where('phone', $arrData['phone'])->first();
            if($rsData){
                $rsData->lap = $rsData->lap + 1;
                $rsData->save();
            }else{
                CrawlData::create($arrData);        
            }
        }
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
        if(isset($arrData['phone'])){
            $rsData = CrawlData::where('phone', $arrData['phone'])->first();
            if($rsData){
                $rsData->lap = $rsData->lap + 1;
                $rsData->save();
            }else{
                CrawlData::create($arrData);        
            }
        }
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
    public function getDetailMbnd($url){ 
 
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
        $arrData['site_id'] = 3;
        if(isset($arrData['phone'])){
            $rsData = CrawlData::where('phone', $arrData['phone'])->first();
            if($rsData){
                $rsData->lap = $rsData->lap + 1;
                $rsData->save();
            }else{
                CrawlData::create($arrData);        
            }
        }
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
