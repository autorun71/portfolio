<?php



Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin/geo')->group(function () {
        Route::group(['middleware' => ['admin']], function () {
            ### Region.Main ###
            Route::prefix('region')->group(function () {
                Route::get('', 'Webkul\Region\Http\Controllers\RegionController@index')->defaults('_config', [
                    'view' => 'region::region.index'
                ])->name('admin.region.index');

                Route::get('edit/{id}', 'Webkul\Region\Http\Controllers\RegionController@edit')->defaults('_config', [
                    'view' => 'region::region.edit'
                ])->name('admin.region.edit');

                Route::put('edit/{id}', 'Webkul\Region\Http\Controllers\RegionController@update')->defaults('_config', [
                    'redirect' => 'admin.region.index'
                ])->name('admin.region.update');

                Route::get('add', 'Webkul\Region\Http\Controllers\RegionController@create')->defaults('_config', [
                    'view' => 'region::region.create'
                ])->name('admin.region.create');

                Route::post('add', 'Webkul\Region\Http\Controllers\RegionController@store')->defaults('_config', [
                    'redirect' => 'admin.region.create'
                ])->name('admin.region.store');

                Route::post('delete/{id}', 'Webkul\Region\Http\Controllers\RegionController@destroy')->name('admin.region.delete');
            });


            ## Region.Props ###
            Route::prefix('props')->group(function () {
                Route::get('', 'Webkul\Region\Http\Controllers\RegionPropsController@index')->defaults('_config', [
                    'view' => 'region::region.props.index'
                ])->name('admin.region.props.index');

                Route::get('edit/{id}', 'Webkul\Region\Http\Controllers\RegionPropsController@edit')->defaults('_config', [
                    'view' => 'region::region.props.edit'
                ])->name('admin.region.props.edit');

                Route::put('edit/{id}', 'Webkul\Region\Http\Controllers\RegionPropsController@update')->defaults('_config', [
                    'redirect' => 'admin.region.props.index'
                ])->name('admin.region.props.update');

                Route::get('add', 'Webkul\Region\Http\Controllers\RegionPropsController@create')->defaults('_config', [
                    'view' => 'region::region.props.create'
                ])->name('admin.region.props.create');

                Route::post('add', 'Webkul\Region\Http\Controllers\RegionPropsController@store')->defaults('_config', [
                    'redirect' => 'admin.region.props.create'
                ])->name('admin.region.props.store');

                Route::post('delete/{id}', 'Webkul\Region\Http\Controllers\RegionPropsController@destroy')->name('admin.region.props.delete');
                Route::post('delete/{id}', 'Webkul\Region\Http\Controllers\RegionPropsController@destroy')->name('admin.region.props.delete');
            });

        });
    });

});