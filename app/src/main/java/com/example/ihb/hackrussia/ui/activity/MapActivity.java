package com.example.ihb.hackrussia.ui.activity;

import android.Manifest;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Criteria;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Build;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;

import com.example.ihb.hackrussia.R;
import com.example.ihb.hackrussia.utils.AppConfig;
import com.example.ihb.hackrussia.utils.ConstantManager;

public class MapActivity extends AppCompatActivity {

    private WebView mWebView;
    private Button mButton;

    private LocationManager locationManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map);

        mButton = (Button) findViewById(R.id.btn);
        initWebViewAndButton();

        locationManager = (LocationManager) getSystemService(LOCATION_SERVICE);

        if (ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.M) {
                requestPermissions(new String[]{Manifest.permission.ACCESS_COARSE_LOCATION,Manifest.permission.ACCESS_FINE_LOCATION,Manifest.permission.INTERNET}
                        ,10);
            }
        } else {
            loadPage();
        }



    }

    private void loadPage() {

        Location location = locationManager.getLastKnownLocation(locationManager.getBestProvider(new Criteria(), true));
        Log.d("LOG", location.getLongitude() + " " + location.getLatitude());locationManager.getLastKnownLocation(locationManager.getBestProvider(new Criteria(),true));


        String typeOfMap = getIntent().getStringExtra(ConstantManager.TYPE_OF_MAP);

        switch (typeOfMap){
            case ConstantManager.GO_TO_CLIENT:
                mWebView.loadUrl("http://informcosm.temp.swtest.ru/accept_call.php?"
                        + "x=" + location.getLatitude()
                        + "&y=" + location.getLongitude()
                        + "&id=" + AppConfig.COACH_ID);
                break;
            case ConstantManager.GO_TO_HOSPITAL:
                mWebView.loadUrl("http://informcosm.temp.swtest.ru/index.php?"
                        + "x=" + location.getLatitude()
                        + "&y=" + location.getLongitude()
                        + "&department=" + getIntent().getStringExtra(ConstantManager.DEPARTMENT_ID));
                break;
            case ConstantManager.GO_TO_WAIT_POINT:
                mWebView.loadUrl("http://informcosm.temp.swtest.ru/call_done.php?"
                        + "x=" + location.getLatitude()
                        + "&y=" + location.getLongitude()
                        + "&id=" + AppConfig.COACH_ID);
                break;
        }
    }

    private void initWebViewAndButton() {
        mWebView = (WebView) findViewById(R.id.web_view);
        mWebView.setWebViewClient(new MyWebViewClient());

        WebSettings webSettings = mWebView.getSettings();
        webSettings.setJavaScriptEnabled(true);

        String typeOfMap = getIntent().getStringExtra(ConstantManager.TYPE_OF_MAP);
        switch (typeOfMap){
            case ConstantManager.GO_TO_CLIENT:
                setTitle(ConstantManager.GO_TO_CLIENT);
                mButton.setText("ПРИБЫЛ");
                mButton.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        startActivity(new Intent(MapActivity.this, DepartmentsActivity.class));
                        finish();
                    }
                });
                break;
            case ConstantManager.GO_TO_HOSPITAL:
                setTitle(ConstantManager.GO_TO_HOSPITAL);
                mButton.setText("ВЫПОЛНЕНО");
                mButton.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        Intent intent = new Intent(MapActivity.this, MapActivity.class);
                        intent.putExtra(ConstantManager.TYPE_OF_MAP, ConstantManager.GO_TO_WAIT_POINT);
                        startActivity(intent);
                        finish();
                    }
                });
                break;
            case ConstantManager.GO_TO_WAIT_POINT:
                setTitle(ConstantManager.GO_TO_WAIT_POINT);
                mButton.setText("ОЖИДАЮ");
                mButton.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        startActivity(new Intent(MapActivity.this, WaitingActivity.class));
                        finish();
                    }
                });
                break;

        }


    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        switch (requestCode){
            case 10:
                loadPage();
                break;
            default:
                break;
        }
    }

    public class MyWebViewClient extends WebViewClient
    {
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url)
        {
            view.loadUrl(url);
            return true;
        }
    }
}


