<?php

namespace App;
use App\Brand;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'brand_id', 'amount',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the Gerente record associated with the Product.
     */
    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');

    }


    public function scopeSearch($query, $inputs)
    {

        if (!isset($inputs['q'])) {
            return $query;
        }



        return $query->where(function ($query) use ($inputs) {
            $query
                 ->orWhere('name', 'like', '%' . $inputs['q'] . '%')
                 ->orWhere('price', 'like', '%' . $inputs['q'] . '%')
                 ->orWhere('amount', 'like', '%' . $inputs['q'] . '%')
                ->orwhereHas('brand', function ($query) use($inputs) {
                    $query->where('name', 'like', '%'.$inputs['q'].'%' );
                })->get();
        });
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
        //limitar possíveis valores invalidos
        if (isset($sort[1]) && (stristr($sort[1],'ASC') || stristr($sort[1],'DESC')) ) {
            $orderby = $sort[1];
        } else return $query;

        return $query->orderBy($sort[0], $orderby);
    }


    public function scopePaginates($query, $inputs)
    {
        $totalpages = 1;
        if (!isset($inputs['p'])) {
            return $query->paginate($totalpages);
        }

        $totalpages = $inputs['p'];


        return $query->paginate($totalpages);
    }

}
