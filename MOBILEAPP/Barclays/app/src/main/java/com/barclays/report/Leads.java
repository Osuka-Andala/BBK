package com.barclays.report;


import android.app.Activity;
import android.content.Context;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.Spinner;
import android.widget.Toast;

import com.barclays.report.adapters.ACAdapterBranch;
import com.barclays.report.global.GlobalVars;
import com.barclays.report.models.Branch;
import com.barclays.report.models.Product;
import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONArray;
import org.json.JSONException;

import java.util.ArrayList;

import cz.msebera.android.httpclient.Header;


/**
 * A simple {@link Fragment} subclass.
 */
public class Leads extends Fragment {

    public Spinner spProductType, spLeadType;
    public Context ctx;
    public AutoCompleteTextView etBranch, etFullName, etTelephone, etAddress, etComments;
    public String branch_id = "", product_id = "";
    public ProgressBar progressBar;
    public Button btSubmit;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_leads, container, false);
        setHasOptionsMenu(true);
        ctx = container.getContext();

        btSubmit = (Button) v.findViewById(R.id.btSubmit);
        spProductType = (Spinner) v.findViewById(R.id.spProduct);
        spLeadType = (Spinner) v.findViewById(R.id.spLeadType);
        progressBar = (ProgressBar) v.findViewById(R.id.progressBar);

        etBranch = (AutoCompleteTextView) v.findViewById(R.id.etBranch);
        etFullName = (AutoCompleteTextView) v.findViewById(R.id.etFullName);
        etTelephone = (AutoCompleteTextView) v.findViewById(R.id.etTelephone);
        etAddress = (AutoCompleteTextView) v.findViewById(R.id.etAddress);
        etComments = (AutoCompleteTextView) v.findViewById(R.id.etComments);

        try {
            ArrayAdapter<String> adapterMerchants = new ArrayAdapter<String>(ctx, R.layout.list_item_sp_top, getStringArray_Object(GlobalVars.products));
            adapterMerchants.setDropDownViewResource(R.layout.list_item_sp);
            spProductType.setAdapter(adapterMerchants);
        } catch (JSONException ex) {
            ex.printStackTrace();
        }


        ArrayAdapter<String> adapterLeadType = new ArrayAdapter<String>(ctx, R.layout.list_item_sp_top, getResources().getStringArray(R.array.lead_type));
        adapterLeadType.setDropDownViewResource(R.layout.list_item_sp);
        spLeadType.setAdapter(adapterLeadType);

        try {
            JSONArray jArray_branches = GlobalVars.branches;
            ArrayList<Branch> arrayList_branch = getArrayList_Branch(jArray_branches);

            final ACAdapterBranch acAdapterBranch = new ACAdapterBranch((Activity) ctx, arrayList_branch);
            etBranch.setAdapter(acAdapterBranch);
            etBranch.setThreshold(1);
            etBranch.setOnFocusChangeListener(new View.OnFocusChangeListener() {

                @Override
                public void onFocusChange(View view, boolean b) {
                    if (!b) {
                        // on focus off
                        String str = etBranch.getText().toString().trim();

                        for (int i = 0; i < acAdapterBranch.getCount(); i++) {
                            String temp = acAdapterBranch.getItem(i).getName();
                            if (str.compareTo(temp) == 0) {
                                return;
                            }
                        }
                        etBranch.setText("");
                    }
                }

            });
            etBranch.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                    branch_id = id + "";
                    System.out.println(id);
                }

            });

            final ArrayList<Product> arrayListProduct = getArrayList_Product(GlobalVars.products);
            ArrayAdapter<Product> adapterProductType = new ArrayAdapter<Product>(ctx, R.layout.list_item_sp_top, arrayListProduct);
            adapterProductType.setDropDownViewResource(R.layout.list_item_sp);
            spProductType.setAdapter(adapterProductType);
            spProductType.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
                @Override
                public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                    product_id = arrayListProduct.get(position).getId() + "";
                    System.out.println(product_id);

                }

                @Override
                public void onNothingSelected(AdapterView<?> parent) {

                }
            });

        } catch (JSONException ex) {
            ex.printStackTrace();
        }
        btSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                preValidate();
            }
        });

        return v;
    }

    private void preValidate() {
        String strUser = GlobalVars.user_id;
        String strBranch = branch_id.trim();
        String strProduct = product_id.trim();

        String strName = etFullName.getText().toString().trim();
        String strTelephone = etTelephone.getText().toString().trim();
        String strAddress = etAddress.getText().toString().trim();
        String strComments = etComments.getText().toString().trim();


        if (strBranch.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_branch), Toast.LENGTH_LONG).show();
        } else if (strName.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_full_name), Toast.LENGTH_LONG).show();
        } else if (strTelephone.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_telephone), Toast.LENGTH_LONG).show();
        } else if (strProduct.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_product), Toast.LENGTH_LONG).show();
        } else if (strUser.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_user), Toast.LENGTH_LONG).show();
        } else {
            //File myFile = new File("/path/to/file.png");j
            RequestParams params = new RequestParams();

            params.put("user_id", strUser);
            params.put("branch_id", strBranch);
            params.put("product_id", strProduct);

            params.put("lead_type", spLeadType.getSelectedItem().toString());
            params.put("name", strName);
            params.put("phone", strTelephone);
            params.put("address", strAddress);
            params.put("comments", strComments);


            AsyncHttpClient client = new AsyncHttpClient();
            client.addHeader("X-Auth-Token", GlobalVars.fung);

            progressBar.setVisibility(View.VISIBLE);
            client.post(GlobalVars.BASE_URL + "leads/save", params, new AsyncHttpResponseHandler() {
                @Override
                public void onSuccess(int statusCode, Header[] headers, byte[] responseBody) {
                    Toast.makeText(ctx, getResources().getString(R.string.success), Toast.LENGTH_LONG).show();
                    progressBar.setVisibility(View.GONE);
                    //JSONObject myObject = new JSONObject(new String(responseBody, "UTF-8"));

                    getFragmentManager().popBackStack(null, FragmentManager.POP_BACK_STACK_INCLUSIVE);
                    getFragmentManager().beginTransaction()
                            .replace(R.id.container, new Home()).commit();


                }

                @Override
                public void onFailure(int statusCode, Header[] headers, byte[] responseBody, Throwable error) {
                    Toast.makeText(ctx, getResources().getString(R.string.failed) + statusCode + " " + error.getMessage(), Toast.LENGTH_LONG).show();
                    progressBar.setVisibility(View.GONE);

                    error.printStackTrace();
                }

                @Override
                public void onProgress(long bytesWritten, long totalSize) {
                    super.onProgress(bytesWritten, totalSize);
                    progressBar.setMax(Integer.parseInt(totalSize + ""));
                    progressBar.setProgress(Integer.parseInt(bytesWritten + ""));

                }

            });


        }
    }


    public static String[] getStringArray_Object(JSONArray jsonArray) throws JSONException {
        String[] stringArray = null;
        int length = jsonArray.length();
        if (jsonArray != null) {
            stringArray = new String[length];
            for (int i = 0; i < length; i++) {
                stringArray[i] = jsonArray.getJSONObject(i).getString("name");
            }
        }
        return stringArray;
    }

    public static ArrayList<Branch> getArrayList_Branch(JSONArray jsonArray) throws JSONException {
        ArrayList<Branch> stringArray = new ArrayList<Branch>();
        int length = jsonArray.length();
        if (jsonArray != null) {

            for (int i = 0; i < length; i++) {
                Branch Branch = new Branch();
                Branch.setName(jsonArray.getJSONObject(i).getString("name"));
                Branch.setId(jsonArray.getJSONObject(i).getLong("id"));
                stringArray.add(Branch);
            }
        }
        return stringArray;
    }

    public static ArrayList<Product> getArrayList_Product(JSONArray jsonArray) throws JSONException {
        ArrayList<Product> stringArray = new ArrayList<Product>();
        int length = jsonArray.length();
        if (jsonArray != null) {

            for (int i = 0; i < length; i++) {
                Product Products = new Product();
                Products.setName(jsonArray.getJSONObject(i).getString("name"));
                Products.setId(jsonArray.getJSONObject(i).getLong("id"));
                stringArray.add(Products);
            }
        }
        return stringArray;
    }

}
