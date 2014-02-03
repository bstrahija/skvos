<?php namespace App\Repositories;

class BaseRepository {

	/**
	 * Collection of results
	 * @var mixed
	 */
	protected $collection;

	/**
	 * Result for single item
	 * @var mixed
	 */
	protected $item;

	/**
	 * Validation errors
	 * @var Illuminate\Support\MessageBag
	 */
	protected $errors;

	/**
	 * Validation service
	 * @var mixed
	 */
	protected $validation;

	/**
	 * Eloquent query builder
	 * @var Builder
	 */
	protected $query;

	/**
	 * Default limit for pagination
	 * @var integer
	 */
	protected $defaultLimit = 20;

	/**
	 * Class for collections
	 * @var string
	 */
	protected $collectionClass = 'App\Resources\Collections\BaseCollection';

	/**
	 * Entity for single item
	 * @var string
	 */
	protected $entityClass = 'App\Resources\Items\BaseItem';

	/**
	 * Available WHERE options
	 * @var array
	 */
	protected $options = array('created_at');

	/**
	 * Return validation errors
	 * @return Illuminate\Support\MessageBag
	 */
	public function errors()
	{
		return $this->errors;
	}

	/**
	 * Simply return limit for pagination
	 * @return integer
	 */
	public function limit($limit = null)
	{
		if ( ! $limit) $limit = $this->defaultLimit;

		return (int) $limit;
	}

	/**
	 * Set query options and params
	 * @param  array  $options
	 * @return Builder
	 */
	public function options($options = array())
	{
		// Get order options
		$orderBy = array_get($options, 'order_by', 'created_at');
		$order   = array_get($options, 'order',    'desc');

		// Run order
		if ($orderBy == 'rand') $this->query->orderBy(DB::raw('RAND()'), $order);
		else                    $this->query->orderBy($orderBy, $order);

		// Also the limit
		if ($limit = array_get($options, 'limit')) $this->defaultLimit = (int) $limit;

		if (is_array($options))
		{
			foreach ($options as $key => $value)
			{
				if ( ! in_array($key, array('limit', 'order_by', 'page', 'token')) and in_array($key, $this->options))
				{
					if (is_array($value))
					{
						$this->query->where($key, $value[0], $value[1]);
					}
					else
					{
						$this->query->where($key, $value);
					}
				}
			}
		}

		return $this->query;
	}

	/**
	 * Return single item
	 * @return Entity
	 */
	public function item($options)
	{
		// Add options
		$this->query = $this->options($options);

		// Get item and entity
		$item      = $this->query->first();
		$itemClass = $this->itemClass;

		if ($item) return new $itemClass($item->toArray());
	}

	/**
	 * Return collection
	 * @return Collection
	 */
	public function collection($options = null)
	{
		// Add options
		$this->query = $this->options($options);

		// Paginate results
		$this->collection = $this->paginate();

		return $this->collection;
	}

	/**
	 * Paginate query results
	 * @param  Builder $query
	 * @param  integer $perPage
	 * @return array
	 */
	public function paginate($perPage = null)
	{
		$collectionClass  = $this->collectionClass;
		$perPage          = $this->limit();
		$this->paginated  = $this->query->paginate($perPage);
		$pagination       = $this->paginated->toArray();
		$this->collection = new $collectionClass(array_get($pagination, 'data'));

		return $this->collection;
	}

}
