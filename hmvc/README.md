# Codeigniter - HMVC #

### How to install ###

* Copy the extensions core files into application/core/ ```MY_Router.php``` ```MY_Loader.php```.
* Create a folder inside the application folder and name it for example ```application/modules/``` ( It could be any name ).
* Add the HMVC path(s) to your ```config.php``` file:

```php
$config['hmvc_paths'] = array(
    'modules/',
);
```
You can add more than one path:

```php
$config['hmvc_paths'] = array(
    'modules/',
    'modules/admins/',
);
```
* In the ```application/modules``` folder create a module directory structure
```
application/articles/
application/articles/controllers/
application/articles/models/
application/articles/views/
```
* Create the needed files:

```
application/articles/controllers/Articles.php
application/articles/models/Article.php
application/articles/views/show.php
```
* Example:

#### Controller ####
```php
//File: Articles.php
<?php

class Articles extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('Article');
	}

	function getArticle($id){
		$article = $this->Article->getArticleById($id);
		$viewData = array();
		$viewData['article'] = $article;
		$this->load->view('hi', $viewData);
	}

}
```
#### Model ####
```php
//File: Article.php
<?php

class Article extends CI_Model{

	function getArticleById($id){
		return "Article No# " . $id;
	}
}
```
#### View ####
```php
<h1>List Articles</h1>
<?php echo $article; ?>

