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
import com.barclays.report.models.Merchant;

import java.util.ArrayList;

/**
 * Created by francis on 23/02/2016.
 */
public class ACAdapterDevices extends BaseAdapter implements Filterable {
    private final Activity activity;
    ArrayList<Merchant> merchants;
    public Context ctx;
    Filter autoCompleteFilter;

    public ACAdapterDevices(Activity activity, ArrayList<Merchant> merchants) {
        assert activity != null;
        assert merchants != null;

        this.merchants = merchants;
        this.activity = activity;
        autoCompleteFilter = new AutoCompleteFilter();
        ctx = activity;
    }

    @Override
    public int getCount() {
        if (null == merchants)
            return 0;
        else
            return merchants.size();
    }

    @Override
    public Merchant getItem(int position) {
        if (null == merchants)
            return null;
        else
            return merchants.get(position);
    }

    @Override
    public long getItemId(int position) {
        Merchant merchant = merchants.get(position);
        return merchant.getId();
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
        ArrayList<Merchant> orig;



        @Override
        public CharSequence convertResultToString(Object resultValue) {
            String str = ((Merchant) (resultValue)).getName();
            return str;
        }

        @Override
        protected FilterResults performFiltering(CharSequence constraint) {
            FilterResults oReturn = new FilterResults();
            ArrayList<Merchant> results = new ArrayList<Merchant>();
            if (orig == null)
                orig = merchants;

            if (constraint != null) {
                if (orig != null && orig.size() > 0) {
                    for (Merchant g : orig) {
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
            merchants = (ArrayList<Merchant>) results.values;
            notifyDataSetChanged();
        }
    }

}
