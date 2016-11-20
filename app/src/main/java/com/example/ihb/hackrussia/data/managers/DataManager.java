package com.example.ihb.hackrussia.data.managers;

import android.content.Context;

import com.example.ihb.hackrussia.data.models.DaoSession;
import com.example.ihb.hackrussia.data.network.RestService;
import com.example.ihb.hackrussia.data.network.ServiceGenerator;
import com.example.ihb.hackrussia.data.network.res.AlertModel;
import com.example.ihb.hackrussia.data.network.res.DepartmentsModel;
import com.example.ihb.hackrussia.utils.MyApplication;
import com.facebook.stetho.inspector.network.ResponseBodyData;

import org.json.JSONObject;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Response;

/**
 * Created by ihb on 20.11.16.
 */

public class DataManager {
    private static DataManager INSTANCE = new DataManager();

    private Context mContext;
    private RestService mRestService;

    private DaoSession mDaoSession;

    public DataManager() {
        this.mContext = MyApplication.getContext();
        this.mRestService = ServiceGenerator.createService(RestService.class);
        this.mDaoSession = MyApplication.getDaoSession();
    }

    public static DataManager getInstance() {
        return INSTANCE;
    }

    public DaoSession getDaoSession(){
        return mDaoSession;
    }

    public Call<DepartmentsModel> getDepartments(){
        return mRestService.getDepartments();
    }

    public Call<AlertModel> getCheck(int x, int y, int id) { return mRestService.getCheck(x, y, id); }
}