<?php namespace Forestest\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Forestest\Models\Base\BaseModel;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/*** getters ***/
	public function getName()
	{
		return $this->attributes['name'];
	}

	public function getEmail()
	{
		return $this->attributes['email'];
	}

	public function getImageUrl()
	{
		return $this->attributes['image_url'];
	}

	/*** setters ***/
	public function setName($name)
	{
		$this->attributes['name'] = $name;
	}

	public function setEmail($email)
	{
		$this->attributes['email'] = $email;
	}

	public function setImageUrl($imageUrl)
	{
		$this->attributes['image_url'] = $imageUrl;
	}

}
