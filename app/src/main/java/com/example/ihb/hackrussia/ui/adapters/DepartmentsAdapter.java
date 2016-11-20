package com.example.ihb.hackrussia.ui.adapters;

import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.example.ihb.hackrussia.R;
import com.example.ihb.hackrussia.data.models.Department;
import com.example.ihb.hackrussia.utils.ConstantManager;

import java.util.List;

/**
 * Created by ihb on 18.11.16.
 */

public class DepartmentsAdapter extends RecyclerView.Adapter<DepartmentsAdapter.DepartmentViewHolder> {

    private static final String TAG = ConstantManager.TAG_PREFIX + " CharactersAdapter";
    private List<Department> mDepartments;
    private DepartmentViewHolder.CustomClickListener mCustomClickListener;

    public DepartmentsAdapter(List<Department> departments, DepartmentViewHolder.CustomClickListener customClickListener) {
        mDepartments = departments;
        this.mCustomClickListener = customClickListener;
    }

    @Override
    public DepartmentsAdapter.DepartmentViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View convertView = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_list,parent,false);
        return new DepartmentViewHolder(convertView, mCustomClickListener);
    }

    @Override
    public void onBindViewHolder(final DepartmentsAdapter.DepartmentViewHolder holder, int position) {
        final Department department = mDepartments.get(position);

        holder.mName.setText(department.getName());
    }

    @Override
    public int getItemCount() {
        return mDepartments.size();
    }

    public List<Department> getDepartments() {
        return mDepartments;
    }

    public static class DepartmentViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener{

        protected TextView mName;

        private  CustomClickListener mListener;

        public DepartmentViewHolder(View itemView, CustomClickListener clickListener) {
            super(itemView);
            this.mListener = clickListener;
            mName = (TextView) itemView.findViewById(R.id.name_txt);

            itemView.setOnClickListener(this);

        }

        @Override
        public void onClick(View v) {
            if(mListener != null){
                mListener.onDepartmentItemClickListener(getAdapterPosition());
            }
        }


        public interface CustomClickListener{
            void onDepartmentItemClickListener(int position);
        }
    }
}