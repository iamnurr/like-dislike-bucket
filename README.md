# Laravel Like Dislike Package

<p align="center">
<a href="https://github.com/iamnurr/like-dislike-bucket/issues"><img src="https://img.shields.io/github/issues/iamnurr/like-dislike-bucket" alt="Issues"></a>
<a href="https://github.com/iamnurr/like-dislike-bucket/stargazers"><img src="https://img.shields.io/github/stars/iamnurr/like-dislike-bucket" alt="Stars"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/twitter/url?url=https%3A%2F%2Fgithub.com%2Fiamnurr%2Flike-dislike-bucket
" alt="Twitter"></a>
</p>

## About Package

This is a package for developers who want to use like and dislike options in their applications, this is the easiest way to do that.

## Installing

This package can be installed through Composer in your application :

##### Run the command.

```shell
composer require nr-type/like-dislike
```

### Migration

After that run the Migration command :

```php
php artisan migrate
```
## Model Use

The model where you want to have like and dislike. 
You just need to use `NrType\LikeDislike\Traits\Likeable` and `NrType\LikeDislike\Traits\Dislikeable`.
 And inside the class use `Likeable` and `Dislikeable`.


```php
use NrType\LikeDislike\Traits\Likeable;
use NrType\LikeDislike\Traits\Dislikeable;

class Post extends Model
{
    use Likeable, Dislikeable;
}
```

##### You can use like dislike options in multiple `Model`

Multiple `Model` are can be `Comment`,`Video`,`Photo`.
```php
use NrType\LikeDislike\Traits\Likeable;
use NrType\LikeDislike\Traits\Dislikeable;

class Comment extends Model
{
    use Likeable, Dislikeable;
}
```

## Optional

Suppose you just only need Like option for your application. 
Then you use `NrType\LikeDislike\Traits\Likeable` and `Likeable`.

```php
use NrType\LikeDislike\Traits\Likeable;

class Post extends Model
{
    use Likeable;
}
```

# Uses in Controller

## Like
Use like option in the post such as like 2 lines of code.

```php
public function like (Post $post)
{
    $post->like();

    return redirect()->route('posts.index');
}
```

### But 
Suppose you want that someone's `click` like button then it will like the post and again he `click` liked button then it will unlike the post. Then here is `removeLike()`. if User alreay like that post it will remove that particular like in the same method or if you want you can create another route and method to unlike the post. 

```php
public function like (Post $post)
{
    if($post->removeLike()){
        return redirect()->route('posts.index');
    }

    $post->like();

    return redirect()->route('posts.index');
}
```

## DisLike
Use dislike in the post same as like in post. For dislike options again you have `dislike()` and `removeDislike()`

```php
public function dislike (Post $post)
{
    $post->dislike();

    return redirect()->route('posts.index');
}
```

### Or  

```php
public function dislike (Post $post)
{
    if ($post->removeDislike()) {
        return redirect()->route('posts.index');
    }

    $post->dislike();

    return redirect()->route('posts.index');
}
```

## Compatibility

`Like` and `Dislike` can work individually and also both are compatible to work with each other, suppose someone like the post and after some time later thinks that he/she wants to dislike the post. He/she just simply click the dislike button, and it will `remove` his/her `like` on that particular post and `dislike`.

## Likers and Dislikers on the Post
You can easily access likers and dislikers through `likers()` and `dislikers()`. default it will return with users `id`,`name` from `users` table.

```php
public function likers (Post $post)
{
    return $post->likers(); 
}
```

### Or

```php
public function dislikers (Post $post)
{
    return $post->dislikers(); 
}
```

#### Now here has somethings
`likers()` and `dislikers()` default return `id`,`name` but you maybe don't need `id`, you may only need `name` or your users database table doesn't have `name` field, it can be `first_name`,`last_name` or maybe something else or maybe you need more then those fields. Here have a solution. You just pass a `array` in side the method. It will return those fields data form users table.

```php
public function likers (Post $post)
{
    $fields = ['id','first_name','last_name','age'];

    return $post->likers($fields); 
}
```

### Or

```php
public function dislikers (Post $post)
{
    $fields = ['id','name','age'];

    return $post->dislikers($fields); 
}
```

## `with()` relationship call in Controller
You can show `likes`, `dislikes` on posts and also want to show how many likes and dislike on posts with `likeCounter`, `dislikeCounter`.

```php
public function index()
{
    $relations = ['likes','likeCounter','dislikes','dislikeCounter'];

    $data['posts'] = Post::with($relations)->get();

    return view('post.index', $data);
}
```

### Or
You may have `comments` on `posts` and you need `comments` and also  need `likes` on particular `comment` and how many `likes` on `comment`. Then you can use `comments.likes` and `comments.likeCounter`.

```php
public function index()
{
    $relations = ['likes','likeCounter','dislikes','dislikeCounter''comments.likes','comments.likeCounter'];

    $data['posts'] = Post::with($relations)->get();

    return view('post.index', $data);
}
```

## Additional options
`hasLike()`, `hasDislike()` is for check that particular user has like or dislike in post or comment. It return `boolean`. You can use  `hasLike()` `hasDislike()` in blades file as well.

```php
{{ $post->hasLike() ? 'Liked' : 'Like' }}
{{ $post->hasDislike() ? 'Disliked' : 'Dislike' }}
```

## License

Like Dislike bucket is open-sourced software licensed under the MIT license.
