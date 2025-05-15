<? php
2 namespace Library ;
3
4 abstract class ApplicationComponent
5 {
6 protected $app ;
7
8 public function __construct ( Application $app )
9 {
10 $this - > app = $app ;
11 }
12
13 public function app ()
14 {
15 return $this - > app ;
16 }
17 }
