<?php namespace App\Repositories;

use DB, Hash;
use App\Models\Comment;
use App\Resources\Collections\CommentCollection;
use App\Resources\Items\CommentItem;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface {

	/**
	 * Class for collections
	 * @var string
	 */
	protected $collectionClass = 'App\Resources\Collections\CommentCollection';

	/**
	 * Class for single comment
	 * @var string
	 */
	protected $itemClass = 'App\Resources\Items\CommentItem';

	/**
	 * Return all comments
	 * @return CommentCollection
	 */
	public function all($options = null)
	{
		$comments = Comment::with(['author'])->get();

		return new CommentCollection($comments->toArray());
	}

	/**
	 * Return single group
	 * @return groupItem
	 */
	public function find($id, $options = null)
	{
		$comment = Comment::with(['author'])->find($id);

		if ($comment) return new CommentItem($comment->toArray());
	}

	/**
	 * Create new comment
	 * @param  arra $data
	 * @return groupItem
	 */
	public function create($data)
	{
		$comment = new Comment;
		$comment->fill($data);
		$comment->save();

		if ($comment) return $this->find($comment->id);
	}

}
