<?php
class bot {

    public function __construct() {
        $this->agent = "Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.4) Gecko/20030624 Netscape/7.1 (ax)";//Agent
        $this->reffer_google = "http://www.google.com/search";//Reffer Google
        $this->reffer_yahoo = "https://answers.yahoo.com";//Reffer Yahoo Answer
        $this->reffer_yahoo_rank = "https://search.yahoo.com/search";//Reffer Yahoo search
        $this->reffer_bing_rank = "https://www.bing.com/search";//Reffer Yahoo search
    }

    public function initSpider( $bot, $keyword, $proxy, $location, $page, $delay ) {
        $url =  $html = '';
        $json = array();

        /*Construct URL*/
        if ( $bot == 'gr' ) {
            if ( $page == 1 )
                $url = 'https://www.google.'.$location.'/search?q='.str_replace( ' ', '+', $keyword ).'&ie=UTF-8&num=100'; //Google Rank
            else
                $url = 'https://www.google.'.$location.'/search?q='.str_replace( ' ', '+', $keyword ).'&ie=UTF-8&num=100&start='.( ( $page-1 )*100 ); //Google Rank
        }elseif ( $bot == 'bing' ) {
            if ( $page == 1 )
                $url = 'http://www.bing.com/search?q='.str_replace( ' ', '+', $keyword ).'&qs=n&form=QBLH&pq='.str_replace( ' ', '+', $keyword ).'&sc=&sp=-1&sk=&cvid=&count=50'; //Rank search
            else
                $url = 'http://www.bing.com/search?q='.str_replace( ' ', '+', $keyword ).'&qs=n&form=QBLH&pq='.str_replace( ' ', '+', $keyword ).'&sc=&sp=-1&sk=&cvid=&count=50&first='.( ( ( $page-1 )*50 )+1 ); //Rank search
        }elseif ( $bot == 'yahoo' ) {
            if ( $page == 1 )
                $url = 'https://'.$location.'search.yahoo.com/search?p='.str_replace( ' ', '+', $keyword ).'&n=100';
            else
                $url = 'https://'.$location.'search.yahoo.com/search?p='.str_replace( ' ', '+', $keyword ).'&n=100&b='.( ( ( $page-1 )*100 )+1 );
        }elseif ( $bot == 'gb' ) {
            $url = 'https://www.google.com/search?q='.str_replace( ' ', '+', $keyword ).':blog&num=100';  //Blog search
        }elseif ( $bot == 'ya' ) {
            $url = 'https://answers.yahoo.com/search/search_result;_ylt=ApbcXMFap1JBQNJIIG0I50Lj1KIX?fr=uh3_answers_vert_gs&type=2button&p='.str_replace( ' ', '+', $keyword );  //Yahoo Answer search
        }

        /*Do crawl*/
        if ( $bot == 'gb' || $bot == 'gr' )
            $html = str_get_html( crawl_simple( $this->reffer_google, $url, $this->agent, $proxy ) );//Google Rank and Blog
        elseif ( $bot == 'bing' )
            $html = str_get_html( crawl_simple( $this->reffer_bing_rank, $url, $this->agent, $proxy ) );//Bing Rank
        elseif ( $bot == 'yahoo' )
            $html = str_get_html( crawl_simple( $this->reffer_yahoo_rank, $url, $this->agent, $proxy ) );//Yahoo Rank

        /*Do parsing*/
        /*Google Rank and Blog parsing*/
        if ( $bot == 'gb' || $bot == 'gr' ) {

            foreach ( $html->find( 'li[class=g]' ) as $index => $li ) {
                $json[$index]['title'] = $li->find( 'a', 0 )->plaintext;
                $json[$index]['description'] = $li->find( 'cite', 0 )->plaintext;
                $json[$index]['url'] = str_replace( '/url?q=', '', $li->find( 'a', 0 )->href );

            }
        }elseif ( $bot == 'yahoo' ) {
            foreach ( $html->find( 'div[class=res]' ) as $index => $div ) {
                //Check for blank data
                if ( count( $div->find( 'h3' ) )>0 ) {
                    $temp_url = explode( 'RU=', urldecode( $div->find( 'h3', 0 )->find( 'a', 0 )->href ) );
                    $temp_url = explode( '/RK=0', $temp_url[1] );
                    if ( !empty( $temp_url[0] ) ) {
                        $json[$index]['title']  = $div->find( 'h3', 0 )->plaintext;
                        $json[$index]['url'] = $temp_url[0];
                        $json[$index]['description'] = $div->find( 'div[class=abstr]', 0 )->plaintext;

                    }
                }
            }
        }elseif ( $bot == 'bing' ) {
            foreach ( $html->find( 'ol#b_results', 0 )->find( 'li[class=b_algo]' ) as $index => $li ) {
                //Check for blank data
                if ( count( $li->find( 'a' ) ) > 0 ) {
                    $json[$index]['title'] = $li->find( 'a', 0 )->plaintext;
                    $json[$index]['url']  = $li->find( 'a', 0 )->href;
                    $json[$index]['description'] = $li->find( 'p', 0 )->plaintext;

                }
            }
        }elseif ( $bot == 'ya' ) {
            /*Yahoo answer parsing*/
            foreach ( $html->find( 'ul[id=yan-questions]', 0 )->find( 'li' ) as $index => $li ) {
                $json[$index]['title'] = $li->find( 'h3', 0 )->find( 'a', 0 )->plaintext;
                $json[$index]['url']  = $this->reffer_yahoo.$li->find( 'h3', 0 )->find( 'a', 0 )->href;
                $json[$index]['question-description']  = $li->find( 'span[class=question-description]', 0 )->plaintext;
                $json[$index]['question-meta'] = $li->find( 'div[class=question-meta]', 0 )->plaintext;

                /*Get answers for each Question*/
                $html_answer = str_get_html( crawl_simple( $this->reffer_yahoo, trim( $this->reffer_yahoo.$li->find( 'h3', 0 )->find( 'a', 0 )->href ), $this->agent, $proxy ) );//Yahoo Answer
                foreach ( $html_answer->find( 'div[class=content]' ) as $answer => $content ) {
                    $json[$index][$answer] = $content->plaintext;
                }
                $html_answer->clear();unset( $html_answer );
                if ( $delay == 1 ) {
                    /*random delay*/
                    sleep( rand( 5, 10 ) );
                }
            }
        }

        if ( $delay == 1 ) {
            /*random delay*/
            sleep( rand( 5, 10 ) );
        }

        return json_encode( $json );
    }
}

?>
