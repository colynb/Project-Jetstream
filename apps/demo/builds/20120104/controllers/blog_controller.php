<?php


use jetstream\core\data\Connection;
use jetstream\core\debug\Debug;

class Blog_Controller extends \jetstream\core\Controller {

	public function action_view() {
		$conn = Connection::get('blog');
		$posts = $conn->getAll('SELECT * FROM posts');
		$this->view->set(compact('posts'));
	}

	public function action_add() {

		if ( isset($this->request->post['post']) ) {
			$conn = Connection::get('blog');
			$url_key = strtolower(str_replace(' ', '-', $this->request->post['title']));
			$title = $this->request->post['title'];
			$post = $this->request->post['post'];
			$created_date = date('YmdHis');
			$params = compact('title','url_key','post','created_date');

			$conn->execute('
				INSERT INTO posts (
					title,
					url_key,
					post,
					created_date
				) VALUES (
					:(string)title,
					:(string)url_key,
					:(string)post,
					:(datetime)created_date
				)', $params);
		}
	}

	public function action_show() {
		$url_key = $this->request->named['post_key'];
		$conn = Connection::get('blog');
		$post = $conn->getRow('SELECT * FROM posts WHERE url_key = :(string)url_key', compact('url_key'));
		$this->view->set(compact('post'));
	}

}