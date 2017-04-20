package com.barclays.report.adapters;

import android.app.Activity;
import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Filter;
import android.widget.Filterable;
import android.widget.TextView;

import com.barclays.report.R;
import com.barclays.report.global.Fonting;
import com.barclays.report.models.Branch;

import java.util.ArrayList;

/**
 * Created by francis on 23/02/2016.
 */
public class ACAdapterBranch extends BaseAdapter implements Filterable {
    private final Activity activity;
    ArrayList<Branch> Branchs;
    public Context ctx;
    Filter autoCompleteFilter;

    public ACAdapterBranch(Activity activity, ArrayList<Branch> Branchs) {
        assert activity != null;
        assert Branchs != null;

        this.Branchs = Branchs;
        this.activity = activity;
        autoCompleteFilter = new AutoCompleteFilter();
        ctx = activity;
    }

    @Override
    public int getCount() {
        if (null == Branchs)
            return 0;
        else
            return Branchs.size();
    }

    @Override
    public Branch getItem(int position) {
        if (null == Branchs)
            return null;
        else
            return Branchs.get(position);
    }

    @Override
    public long getItemId(int position) {
        Branch Branch = Branchs.get(position);
        return Branch.getId();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null)
            convertView = activity.getLayoutInflater().inflate(
                    R.layout.list_item_sp, null);

        TextView tvName = (TextView) convertView.findViewById(android.R.id.text1);

        tvName.setTypeface(Fonting.getFont(ctx, Fonting.KEY_LIGHT));
        tvName.setText(getItem(position).getName());

        return convertView;

    }

    @Override
    public Filter getFilter() {
        return autoCompleteFilter;

    }

    public class AutoCompleteFilter extends Filter {
        ArrayList<Branch> orig;



        @Override
        public CharSequence convertResultToString(Object resultValue) {
            String str = ((Branch) (resultValue)).getName();
            return str;
        }

        @Override
        protected FilterResults performFiltering(CharSequence constraint) {
            FilterResults oReturn = new FilterResults();
            ArrayList<Branch> results = new ArrayList<Branch>();
            if (orig == null)
                orig = Branchs;

            if (constraint != null) {
                if (orig != null && orig.size() > 0) {
                    for (Branch g : orig) {
                        if (g.getName().toString().toLowerCase().contains(constraint.toString().toLowerCase()))
                            results.add(g);
                    }
                }
                oReturn.values = results;
            }
            return oReturn;
        }

        @Override
        protected void publishResults(CharSequence constraint, FilterResults results) {
            Branchs = (ArrayList<Branch>) results.values;
            notifyDataSetChanged();
        }
    }

}
