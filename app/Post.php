<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'posts';

    protected $fillable = [
		'title',
		'content'
	];
}
