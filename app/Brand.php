<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Product;

class Brand extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'brands';
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name', 'id',
    ];

    /**
     * O Brand pode possuir várias produtos
     *
     * @var array
     */

    public function products(){
        return $this->hasMany(Product::class);
    }


    public function scopeSearch($query, $inputs)
    {

        if (!isset($inputs['q'])) {
            return $query;
        }

        $result= $query->where(function ($query) use ($inputs) {
            $query
                 ->orWhere('name', 'like', '%' . $inputs['q'] . '%')
                 ->orwhereHas('products', function ($query) use($inputs) {
                    $query->where('name', 'like', '%'.$inputs['q'].'%' );
                })->get();
            });
    
            return $result;

    }

    public function scopeFilter($query, $inputs)
    {
        if (!isset($inputs['filter'])) {
            return $query;
        }

        $filter = explode(':', $inputs['filter']);
        return $query->where($filter[0], $filter[1]);
    }

    public function scopeSort($query, $inputs)
    {
        if (!isset($inputs['sort'])) {
            return $query;
        }

        $orderby = 'ASC';
        $sort = explode(',', $inputs['sort']);

        if (isset($sort[1])) {
            $orderby = $sort[1];
        }

        return $query->orderBy($sort[0], $orderby);
    }
    public function scopePaginates($query, $inputs)
    {
        $totalpages = 3;
        if (!isset($inputs['p'])) {
            return $query->paginate($totalpages);
        }

        $totalpages = $inputs['p'];


        return $query->paginate($totalpages);
        
    }
}