package com.example.ihb.hackrussia.ui.activity;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;

import com.example.ihb.hackrussia.R;
import com.example.ihb.hackrussia.data.managers.DataManager;
import com.example.ihb.hackrussia.data.models.Department;
import com.example.ihb.hackrussia.ui.adapters.DepartmentsAdapter;
import com.example.ihb.hackrussia.utils.AppConfig;
import com.example.ihb.hackrussia.utils.ConstantManager;

import java.util.ArrayList;
import java.util.List;

public class DepartmentsActivity extends AppCompatActivity {

    RecyclerView mRecyclerView;

    List<Department> departmentList;

    DepartmentsAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_departments);

        mRecyclerView = (RecyclerView) findViewById(R.id.department_list);

        departmentList = DataManager.getInstance().getDaoSession().getDepartmentDao().loadAll();
        adapter = new DepartmentsAdapter(departmentList, new DepartmentsAdapter.DepartmentViewHolder.CustomClickListener() {
            @Override
            public void onDepartmentItemClickListener(int position) {
                Log.d("LOG", departmentList.get(position).getName());
                Intent intent = new Intent(DepartmentsActivity.this, MapActivity.class);
                intent.putExtra(ConstantManager.DEPARTMENT_ID, departmentList.get(position).getRemote_id());
                intent.putExtra(ConstantManager.TYPE_OF_MAP, ConstantManager.GO_TO_HOSPITAL);
                startActivity(intent);
                finish();
            }
        });

        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(this);
        mRecyclerView.setLayoutManager(linearLayoutManager);
        mRecyclerView.swapAdapter(adapter, false);
    }
}
