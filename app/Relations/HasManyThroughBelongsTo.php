<?php namespace App\Relations;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Expression;

class HasManyThroughBelongsTo extends Relation
{

    /**
     * The distance parent model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $farParent;

    /**
     * The near key on the relationship.
     *
     * @var string
     */
    protected $firstKey;

    /**
     * The far key on the relationship.
     *
     * @var string
     */
    protected $secondKey;

    /**
     * @param Builder $query
     * @param Model   $farParent
     * @param Model   $pivotModel
     * @param         $firstKey
     * @param         $secondKey
     */
    public function __construct( Builder $query, Model $farParent, Model $pivotModel, $firstKey, $secondKey )
    {
        $this->firstKey  = $firstKey;
        $this->secondKey = $secondKey;
        $this->farParent = $farParent;
        parent::__construct( $query, $pivotModel );
    }

    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints()
    {
        $parentTable = $this->parent->getTable();

        $this->setJoin();

        if ( static::$constraints )
        {
            $this->query->where( $parentTable . '.' . $this->firstKey, '=', $this->farParent->getKey() );
        }
    }

    /**
     * Add the constraints for a relationship count query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \Illuminate\Database\Eloquent\Builder $parent
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getRelationCountQuery( Builder $query, Builder $parent )
    {
        $parentTable = $this->parent->getTable();

        $this->setJoin( $query );

        $query->select( new Expression( 'count(*)' ) );

        $key = $this->wrap( $parentTable . '.' . $this->firstKey );

        return $query->where( $this->getHasCompareKey(), '=', new Expression( $key ) );
    }

    /**
     * Set the join clause on the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder|null $query
     * @return void
     */
    protected function setJoin( Builder $query = null )
    {
        $query = $query ?: $this->query;
        $left  = $this->parent->getTable() . '.' . $this->secondKey;
        $right = $this->related->getQualifiedKeyName();
        $query->join( $this->parent->getTable(), $left, '=', $right );
    }

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param  array $models
     * @return void
     */
    public function addEagerConstraints( array $models )
    {
        $table = $this->parent->getTable();
        $this->query->whereIn( $table . '.' . $this->firstKey, $this->getKeys( $models ) );
    }

    /**
     * Initialize the relation on a set of models.
     *
     * @param  array  $models
     * @param  string $relation
     * @return array
     */
    public function initRelation( array $models, $relation )
    {
        foreach ( $models as $model )
        {
            $model->setRelation( $relation, $this->related->newCollection() );
        }

        return $models;
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param  array                                    $models
     * @param  \Illuminate\Database\Eloquent\Collection $results
     * @param  string                                   $relation
     * @return array
     */
    public function match( array $models, Collection $results, $relation )
    {
        $dictionary = $this->buildDictionary( $results );

        // Once we have the dictionary we can simply spin through the parent models to
        // link them up with their children using the keyed dictionary to make the
        // matching very convenient and easy work. Then we'll just return them.
        foreach ( $models as $model )
        {
            $key = $model->getKey();

            if ( isset( $dictionary[ $key ] ) )
            {
                $value = $this->related->newCollection( $dictionary[ $key ] );

                $model->setRelation( $relation, $value );
            }
        }

        return $models;
    }

    /**
     * Build model dictionary keyed by the relation's foreign key.
     *
     * @param  \Illuminate\Database\Eloquent\Collection $results
     * @return array
     */
    protected function buildDictionary( Collection $results )
    {
        $dictionary = [ ];

        $foreign = $this->firstKey;

        // First we will create a dictionary of models keyed by the foreign key of the
        // relationship as this will allow us to quickly access all of the related
        // models without having to do nested looping which will be quite slow.
        foreach ( $results as $result )
        {
            $dictionary[ $result->{$foreign} ][ ] = $result;
        }

        return $dictionary;
    }

    /**
     * Get the results of the relationship.
     *
     * @return mixed
     */
    public function getResults()
    {
        return $this->get();
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get( $columns = [ '*' ] )
    {
        // First we'll add the proper select columns onto the query so it is run with
        // the proper columns. Then, we will get the results and hydrate out pivot
        // models with the result of those columns as a separate model relation.
        $select = $this->getSelectColumns( $columns );

        $models = $this->query->addSelect( $select )
            ->getModels();

        // If we actually found models we will also eager load any relationships that
        // have been specified as needing to be eager loaded. This will solve the
        // n + 1 query problem for the developer and also increase performance.
        if ( count( $models ) > 0 )
        {
            $models = $this->query->eagerLoadRelations( $models );
        }

        return $this->related->newCollection( $models );
    }

    /**
     * Set the select clause for the relation query.
     *
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    protected function getSelectColumns( array $columns = [ '*' ] )
    {
        if ( $columns == [ '*' ] )
        {
            $columns = [ $this->related->getTable() . '.*' ];
        }

        return array_merge( $columns, [ $this->parent->getTable() . '.' . $this->firstKey ] );
    }

    /*
     * Get a paginator for the "select" statement.
     *
     * @param  int    $perPage
     * @param  array  $columns
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate( $perPage = null, $columns = [ '*' ] )
    {
        $this->query->addSelect( $this->getSelectColumns( $columns ) );

        return $this->query->paginate( $perPage, $columns );
    }

    /**
     * Get the key for comparing against the parent key in "has" query.
     *
     * @return string
     */
    public function getHasCompareKey()
    {
        return $this->farParent->getQualifiedKeyName();
    }

}