package com.example.ihb.hackrussia.ui.activity;

import android.content.Intent;
import android.net.Uri;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

import com.example.ihb.hackrussia.R;
import com.example.ihb.hackrussia.data.managers.DataManager;
import com.example.ihb.hackrussia.data.models.Department;
import com.example.ihb.hackrussia.data.network.res.AlertModel;
import com.example.ihb.hackrussia.data.network.res.DepartmentsModel;
import com.example.ihb.hackrussia.utils.AppConfig;
import com.google.android.gms.appindexing.Action;
import com.google.android.gms.appindexing.AppIndex;
import com.google.android.gms.appindexing.Thing;
import com.google.android.gms.common.api.GoogleApiClient;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class WaitingActivity extends AppCompatActivity {

    final Handler handler = new Handler();
    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    private GoogleApiClient mClient;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_waiting);

        downloadDepartments();

        handler.postDelayed(new Runnable() {
            @Override
            public void run() {
                checkForCall();
            }
        }, 2000);
        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        mClient = new GoogleApiClient.Builder(this).addApi(AppIndex.API).build();
    }

    private void downloadDepartments() {
        DataManager.getInstance().getDepartments().enqueue(new Callback<DepartmentsModel>() {
            @Override
            public void onResponse(Call<DepartmentsModel> call, Response<DepartmentsModel> response) {
                parseResponse(response.body().text);
            }

            @Override
            public void onFailure(Call<DepartmentsModel> call, Throwable t) {

            }
        });
    }

    private void parseResponse(String text) {

        List<Department> departments = new ArrayList<>();
        String[] pairs = text.split("&");

        for (int i = 0; i < pairs.length; i++) {
            String[] pair = pairs[i].split("\\|");
            departments.add(new Department(pair[0], pair[1]));
        }

        DataManager.getInstance().getDaoSession().getDepartmentDao().deleteAll();
        DataManager.getInstance().getDaoSession().getDepartmentDao().insertInTx(departments);
    }


    private void checkForCall() {
        DataManager.getInstance().getCheck(10, 10, AppConfig.COACH_ID).enqueue(new Callback<AlertModel>() {
            @Override
            public void onResponse(Call<AlertModel> call, Response<AlertModel> response) {
                if ("1".equals(response.body().text)) {
                    startActivity(new Intent(WaitingActivity.this, AlertActivity.class));
                    finish();
                } else {
                    handler.postDelayed(new Runnable() {
                        @Override
                        public void run() {
                            checkForCall();
                        }
                    }, 2000);
                }
            }

            @Override
            public void onFailure(Call<AlertModel> call, Throwable t) {
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        checkForCall();
                    }
                }, 2000);
            }
        });
    }

    /**
     * ATTENTION: This was auto-generated to implement the App Indexing API.
     * See https://g.co/AppIndexing/AndroidStudio for more information.
     */
    public Action getIndexApiAction() {
        Thing object = new Thing.Builder()
                .setName("Waiting Page") // TODO: Define a title for the content shown.
                // TODO: Make sure this auto-generated URL is correct.
                .setUrl(Uri.parse("http://[ENTER-YOUR-URL-HERE]"))
                .build();
        return new Action.Builder(Action.TYPE_VIEW)
                .setObject(object)
                .setActionStatus(Action.STATUS_TYPE_COMPLETED)
                .build();
    }

    @Override
    public void onStart() {
        super.onStart();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        mClient.connect();
        AppIndex.AppIndexApi.start(mClient, getIndexApiAction());
    }

    @Override
    public void onStop() {
        super.onStop();

        // ATTENTION: This was auto-generated to implement the App Indexing API.
        // See https://g.co/AppIndexing/AndroidStudio for more information.
        AppIndex.AppIndexApi.end(mClient, getIndexApiAction());
        mClient.disconnect();
    }
}
