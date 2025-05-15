1 <? php
2 namespace Library ;
3
4 class HTTPRequest
5 {private $app;

public function __construct(Application $app){
    $this->app = $app;
}

6 public function cookieData ( $key )
7 {
8 return isset ( $_COOKIE [ $key ]) ? $_COOKIE [ $key ] : null ;
9 }
10
11 public function cookieExists ( $key )
12 {
13 return isset ( $_COOKIE [ $key ]) ;
14 }
15
16 public function getData ( $key )
17 {
18 return isset ( $_GET [ $key ]) ? $_GET [ $key ] : null ;
19 }
20
21 public function getExists ( $key )
22 {
23 return isset ( $_GET [ $key ]) ;
24 }
25
26 public function method ()
27 {
28 return $_SERVER [ ' REQUEST_METHOD '];
29 }
30
31 public function postData ( $key )
32 {
33 return isset ( $_POST [ $key ]) ? $_POST [ $key ] : null ;
34 }
35
36 public function postExists ( $key )
37 {
38 return isset ( $_POST [ $key ]) ;
39 }
40
41 public function requestURI ()
42 {
43 return $_SERVER [ ' REQUEST_URI '];
44 }
45 }