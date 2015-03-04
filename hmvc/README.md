# Codeigniter 3 - HMVC #

### How to install ###

* Copy the extensions core files ( ```MY_Router.php``` ```MY_Loader.php``` ) into ```application/core/``` .
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
application/modules/articles/
application/modules/articles/controllers/
application/modules/articles/models/
application/modules/articles/views/
```
* Create the needed files:

```
application/modules/articles/controllers/Articles.php
application/modules/articles/models/Article.php
application/modules/articles/views/show.php
```
* Example:

#### Controller ####
```php
//File: application/articles/controllers/Articles.php
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
		$this->load->view('show', $viewData);
	}

}
```
#### Model ####
```php
//File: application/articles/models/Article.php
<?php

class Article extends CI_Model{

	function getArticleById($id){
		return "Article No# " . $id;
	}
}
```
#### View ####
```php
//File: application/articles/views/show.php
<h1>List Articles</h1>
<?php echo $article; ?>

