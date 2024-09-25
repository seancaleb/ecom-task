<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable {
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable {
        $query->where('user_id', request()->user()->id);

        return (new EloquentDataTable($query))
            ->addColumn('action', 'products.action')
            ->addColumn('description', function ($product) {
                $formatted_description = wordwrap($product->description, 50, "\n", true);
                $lines = explode("\n", $formatted_description);
                $truncated_description = implode("\n", array_slice($lines, 0, 2));
                return "{$truncated_description}...";
            })
            ->addColumn('price', function ($product) {
                return number_format($product->price, 0, '.', ',');
            })
            ->addColumn('created_at', function ($product) {
                $formattedDate = $product->created_at->format('Y-m-d');
                return $formattedDate;
            })
            ->addColumn('actions', content: function ($product) {
                $editLink = route('products.edit', $product);
                $deleteFormAction = route('products.destroy', $product);

                return [$editLink, $deleteFormAction];
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('add'),
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array {
        return [
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-center'),
            Column::make('id'),
            Column::make('name'),
            Column::make('description'),
            Column::make('price'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string {
        return 'Products_' . date('YmdHis');
    }
}
