<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model {


	protected $table = 'author';
	protected $fillable = ['name'];
}
