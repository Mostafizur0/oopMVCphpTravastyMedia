<?php
    class Posts extends Controller
    {
        public function __construct () {
            if(!isLoggedIn()) {
                redirect('users/login');
            }

            $this->postModel = $this->model('Post');
            $this->userModel = $this->model('User');
        }

        public function index () {
            $posts = $this->postModel->getPosts();
            $data = [
                'posts'=> $posts,
            ];
            $this->view('posts/index', $data);
        }

        public function add () {
            if($_SERVER['REQUEST_METHOD']=='POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'title'=> trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }

                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body';
                }

                if(empty($data['title_err']) && empty($data['body_err'])){
                    if($this->postModel->addPost($data)) {
                        flash('post_massage', 'Post added');
                        redirect('posts');
                    }else {
                        die('Error in add post');
                    }
                } else {
                    //flash('post_massage');
                    $this->view('posts/add', $data);
                }
            } else {
                $data = [
                    'title'=> '',
                    'body' => ''
                ];
                $this->view('posts/add', $data);
            }
        }

        public function edit ($id) {
            if($_SERVER['REQUEST_METHOD']=='POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'id' => $id,
                    'title'=> trim($_POST['title']),
                    'body' => trim($_POST['body']),
                    'user_id' => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err' => ''
                ];

                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }

                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body';
                }

                if(empty($data['title_err']) && empty($data['body_err'])){
                    if($this->postModel->updatePost($data)) {
                        flash('post_massage', 'Post updated');
                        redirect('posts');
                    }else {
                        die('Error in update post');
                    }
                } else {
                    $this->view('posts/edit', $data);
                }
            } else {
                $post = $this->postModel->getPostById($id);

                if($post->user_id != $_SESSION['user_id']) {
                    redirect('posts');
                }

                $data = [
                    'id' => $id,
                    'title'=> $post->title,
                    'body' => $post->body
                ];
                $this->view('posts/edit', $data);
            }
        }

        public function show($id) {
            $post = $this->postModel->getPostById($id);
            $user = $this->userModel->getUserById($post->user_id);

            $data = [
                'post' => $post,
                'user' => $user
            ];

            $this->view('posts/show', $data);
        }

        public function delete ($id) {
            if($_SERVER['REQUEST_METHOD']=='POST') {
                $post = $this->postModel->getPostById($id);

                if($post->user_id != $_SESSION['user_id']) {
                    redirect('posts');
                }

                if($this->postModel->deletePost($id)) {
                    flash('post_massage', 'Post deleted');
                    redirect('posts');
                } else {
                    die('Error in delete post');
                }
            } else {
                redirect('posts');
            }
        }
    }
    
?>