package com.barclays.report.adapters;

/**
 * Created by francis on 7/3/2014.
 */


import android.app.Activity;
import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.ListAdapter;
import android.widget.TextView;


import com.barclays.report.R;
import com.barclays.report.global.Fonting;
import com.barclays.report.textdrawable.TextDrawable;
import com.barclays.report.textdrawable.util.ColorGenerator;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


public class CustomersAdapter extends BaseAdapter implements ListAdapter {
    private final Activity activity;
    private final JSONArray jsonArray;
    public Context ctx;
    public static int customer_count = 0;

    public CustomersAdapter(Activity activity, JSONArray jsonArray) {
        assert activity != null;
        assert jsonArray != null;

        this.jsonArray = jsonArray;
        this.activity = activity;
        ctx = activity;
    }

    @Override
    public int getCount() {
        if (null == jsonArray)
            return 0;
        else
            return jsonArray.length();
    }

    @Override
    public JSONObject getItem(int position) {
        if (null == jsonArray)
            return null;
        else
            return jsonArray.optJSONObject(position);
    }

    @Override
    public long getItemId(int position) {
        JSONObject jsonObject = getItem(position);

        return jsonObject.optLong("id");

    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        if (convertView == null)
            convertView = activity.getLayoutInflater().inflate(
                    R.layout.list_row_customers, null);
        customer_count++;

        TextView tvCustomerName = (TextView) convertView.findViewById(R.id.tvCustomerName); // title
        TextView tvCustomerPhone = (TextView) convertView.findViewById(R.id.tvPhoneNumber); // title
        ImageView imgAvatar = (ImageView) convertView.findViewById(R.id.imgAvatar); // title
        TextView tvDate = (TextView) convertView.findViewById(R.id.tvTime);

        tvCustomerName.setTypeface(Fonting.getFont(ctx, Fonting.KEY_LIGHT));
        tvCustomerPhone.setTypeface(Fonting.getFont(ctx, Fonting.KEY_CONDENSED_LIGHT));
        tvDate.setTypeface(Fonting.getFont(ctx, Fonting.KEY_LIGHT));


        JSONObject json_data = getItem(position);
        if (null != json_data) {
            try {
                String strName1 = json_data.getString("surname");
                String strName2 = json_data.getString("firstname");
                String strName3 = json_data.getString("othername");

                String strPhone = json_data.getString("telephone");
                String created_at = json_data.getString("created_at");

                String customer_fullname = strName1 + " " + strName2 + " " + strName3;
                tvCustomerName.setText(customer_fullname.toUpperCase());
                tvCustomerPhone.setText(strPhone);
                tvDate.setText("joined " + created_at.split("T")[0]);

                ColorGenerator generator = ColorGenerator.DEFAULT;
                int color = generator.getRandomColor();

                TextDrawable.IBuilder builder = TextDrawable.builder()
                        .beginConfig()
                        .withBorder(1)
                        .endConfig()
                        .rect();
                char letter1 = strName1.toUpperCase().charAt(0);
                char letter2 = strName2.toUpperCase().charAt(0);
                TextDrawable drawable = builder.build(letter1 + "" + letter2, color);
                imgAvatar.setImageDrawable(drawable);


            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
        return convertView;
    }
}
