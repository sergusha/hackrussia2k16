package com.example.ihb.hackrussia.data.network;

import com.example.ihb.hackrussia.data.network.res.AlertModel;
import com.example.ihb.hackrussia.data.network.res.DepartmentsModel;

import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Path;
import retrofit2.http.Query;

/**
 * Created by ihb on 14.10.16.
 */

public interface RestService {

    @GET("get_departments_list.php")
    Call<DepartmentsModel> getDepartments();

    @GET("check_call_for_coach.php")
    Call<AlertModel> getCheck(@Query("x") int x, @Query("y") int y, @Query("id") int id);
}

