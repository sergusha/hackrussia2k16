package com.example.ihb.hackrussia.ui.activity;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;

import com.example.ihb.hackrussia.R;
import com.example.ihb.hackrussia.utils.ConstantManager;

public class AlertActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_alert);

        findViewById(R.id.go_btn).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(AlertActivity.this, MapActivity.class);
                intent.putExtra(ConstantManager.TYPE_OF_MAP, ConstantManager.GO_TO_CLIENT);
                startActivity(intent);
                finish();
            }
        });
    }
}
