package com.barclays.report;


import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.provider.MediaStore;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v7.app.AlertDialog;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.Spinner;
import android.widget.Toast;

import com.barclays.report.adapters.ACAdapterMerchant;
import com.barclays.report.global.GlobalVars;
import com.barclays.report.models.Devices;
import com.barclays.report.models.Merchant;
import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONArray;
import org.json.JSONException;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import cz.msebera.android.httpclient.Header;


/**
 * A simple {@link Fragment} subclass.
 */
public class Report extends Fragment {
    public Spinner spDeviceType;
    public Context ctx;
    public AutoCompleteTextView etMerchant;
    public AutoCompleteTextView etLocation, etIssue, etIssueOther, etSerialNumber, etComments;
    public Button btSubmit;
    public String merchant_id, device_id;
    public List<Devices> lstDevices;
    public ProgressBar progressBar;

    ImageView imgPhoto;
    Bitmap inc_photo;
    Uri photo_uri;
    File f;

    public static String IMAGE_TAG = "barc_lastitaken_image.jpg";
    int REQUEST_CAMERA = 0, SELECT_FILE = 1;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_report, container, false);

        ctx = container.getContext();
        progressBar = (ProgressBar) v.findViewById(R.id.progressBar);

        spDeviceType = (Spinner) v.findViewById(R.id.spDeviceType);
        etMerchant = (AutoCompleteTextView) v.findViewById(R.id.etMerchant);
        etLocation = (AutoCompleteTextView) v.findViewById(R.id.etLocation);
        etIssue = (AutoCompleteTextView) v.findViewById(R.id.etIssue);
        etIssueOther = (AutoCompleteTextView) v.findViewById(R.id.etIssueOther);
        etComments = (AutoCompleteTextView) v.findViewById(R.id.etComments);
        etSerialNumber = (AutoCompleteTextView) v.findViewById(R.id.etSerialNumber);
        btSubmit = (Button) v.findViewById(R.id.btSubmit);
        btSubmit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                preValidate();
            }
        });

        imgPhoto = (ImageView) v.findViewById(R.id.imgPhoto);

        imgPhoto.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                selectImage();
            }
        });

        try {
            JSONArray jArray_merchants = GlobalVars.merchants;
            ArrayList<Merchant> arrayListMerchant = getArrayList_Merchant(jArray_merchants);

            final ACAdapterMerchant acAdapterMerchant = new ACAdapterMerchant((Activity) ctx, arrayListMerchant);
            etMerchant.setAdapter(acAdapterMerchant);
            etMerchant.setThreshold(1);
            etMerchant.setOnFocusChangeListener(new View.OnFocusChangeListener() {

                @Override
                public void onFocusChange(View view, boolean b) {
                    if (!b) {
                        // on focus off
                        String str = etMerchant.getText().toString().trim();

                        for (int i = 0; i < acAdapterMerchant.getCount(); i++) {
                            String temp = acAdapterMerchant.getItem(i).getName();
                            if (str.compareTo(temp) == 0) {
                                return;
                            }
                        }
                        etMerchant.setText("");
                    }
                }

            });
            etMerchant.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                    merchant_id = id + "";
                    System.out.println(id);
                }

            });

            final ArrayList<Devices> arrayListDevices = getArrayList_Devices(GlobalVars.devices);
            ArrayAdapter<Devices> adapterDeviceType = new ArrayAdapter<Devices>(ctx, R.layout.list_item_sp_top, arrayListDevices);
            adapterDeviceType.setDropDownViewResource(R.layout.list_item_sp);
            spDeviceType.setAdapter(adapterDeviceType);
            spDeviceType.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
                @Override
                public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                    device_id = arrayListDevices.get(position).getId() + "";
                    System.out.println(device_id);

                }

                @Override
                public void onNothingSelected(AdapterView<?> parent) {

                }
            });


        } catch (JSONException ex) {
            ex.printStackTrace();
        }


        return v;
    }

    private void preValidate() {
        String strUser = GlobalVars.user_id;
        String strMerchant = merchant_id.trim();
        String strDevice = device_id.trim();

        String strLocation = etLocation.getText().toString().trim();
        String strIssue = etIssue.getText().toString().trim();
        String strIssueOther = etIssueOther.getText().toString().trim();
        String strComments = etComments.getText().toString().trim();
        String strSerialNumber = etSerialNumber.getText().toString().trim();


        if (strMerchant.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_merchant), Toast.LENGTH_LONG).show();
        } else if (strLocation.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_location), Toast.LENGTH_LONG).show();
        } else if (strIssue.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_issue), Toast.LENGTH_LONG).show();
        } else if (strDevice.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_device), Toast.LENGTH_LONG).show();
        } else if (strUser.isEmpty()) {
            Toast.makeText(ctx, ctx.getResources().getString(R.string.missing_user), Toast.LENGTH_LONG).show();
        } else {
            //File myFile = new File("/path/to/file.png");j
            RequestParams params = new RequestParams();
            try {
                params.put("image", f);

            } catch (FileNotFoundException e) {
                e.printStackTrace();
            }
            params.put("user_id", strUser);
            params.put("merchant_id", strMerchant);
            params.put("device_id", strDevice);

            params.put("location", strMerchant);
            params.put("issue", strIssue);
            params.put("issue_other", strIssueOther);
            params.put("serial_no", strSerialNumber);
            params.put("comments", strComments);


            AsyncHttpClient client = new AsyncHttpClient();
            client.addHeader("X-Auth-Token", GlobalVars.fung);

            progressBar.setVisibility(View.VISIBLE);
            client.post(GlobalVars.BASE_URL + "issue/save", params, new AsyncHttpResponseHandler() {
                @Override
                public void onSuccess(int statusCode, Header[] headers, byte[] responseBody) {
                    Toast.makeText(ctx, getResources().getString(R.string.success), Toast.LENGTH_LONG).show();
                    progressBar.setVisibility(View.GONE);
                    //JSONObject myObject = new JSONObject(new String(responseBody, "UTF-8"));

                    //onBackPressed();
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

    //new photo stuff
    private void selectImage() {
        final CharSequence[] items = {getResources().getString(R.string.take_photo), getResources().getString(R.string.choose_photo),
                getResources().getString(R.string.cancel)};

        AlertDialog.Builder builder = new AlertDialog.Builder(ctx);
        builder.setTitle(getResources().getString(R.string.add_photo));
        builder.setItems(items, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int item) {
                if (items[item].equals(getResources().getString(R.string.take_photo))) {
                    Intent intent = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                    File f = new File(Environment.getExternalStorageDirectory(), IMAGE_TAG);
                    intent.putExtra(MediaStore.EXTRA_OUTPUT, Uri.fromFile(f));
                    startActivityForResult(intent, REQUEST_CAMERA);
                } else if (items[item].equals(getResources().getString(R.string.choose_photo))) {
                    Intent intent = new Intent(
                            Intent.ACTION_PICK,
                            MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                    intent.setType("image/*");
                    startActivityForResult(
                            Intent.createChooser(intent, getResources().getString(R.string.select_photo)),
                            SELECT_FILE);
                } else if (items[item].equals(getResources().getString(R.string.cancel))) {
                    dialog.dismiss();
                }
            }
        });
        builder.show();
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (resultCode == Activity.RESULT_OK) {
            if (requestCode == SELECT_FILE)
                onSelectFromGalleryResult(data);
            else if (requestCode == REQUEST_CAMERA)
                onCaptureImageResult(data);
        }
    }

    private void onCaptureImageResult(Intent data) {
        File destination = new File(Environment.getExternalStorageDirectory(), IMAGE_TAG);
        Bitmap bm;
        BitmapFactory.Options options = new BitmapFactory.Options();
        options.inJustDecodeBounds = true;
        BitmapFactory.decodeFile(destination.getAbsolutePath(), options);
        final int REQUIRED_SIZE = 500;
        int scale = 1;
        while (options.outWidth / scale / 2 >= REQUIRED_SIZE
                && options.outHeight / scale / 2 >= REQUIRED_SIZE)
            scale *= 2;
        options.inSampleSize = scale;
        options.inJustDecodeBounds = false;
        bm = BitmapFactory.decodeFile(destination.getAbsolutePath(), options);

        imgPhoto.setImageBitmap(bm);
        bitmapToFile(IMAGE_TAG, bm);

    }

    //    @SuppressWarnings("deprecation")
    private void onSelectFromGalleryResult(Intent data) {
        Uri selectedImageUri = data.getData();
        String[] projection = {MediaStore.MediaColumns.DATA};
        Cursor cursor = getActivity().managedQuery(selectedImageUri, projection, null, null,
                null);
        int column_index = cursor.getColumnIndexOrThrow(MediaStore.MediaColumns.DATA);
        cursor.moveToFirst();

        String selectedImagePath = cursor.getString(column_index);

        Bitmap bm;
        BitmapFactory.Options options = new BitmapFactory.Options();
        options.inJustDecodeBounds = true;
        BitmapFactory.decodeFile(selectedImagePath, options);
        final int REQUIRED_SIZE = 500;
        int scale = 1;
        while (options.outWidth / scale / 2 >= REQUIRED_SIZE
                && options.outHeight / scale / 2 >= REQUIRED_SIZE)
            scale *= 2;
        options.inSampleSize = scale;
        options.inJustDecodeBounds = false;
        bm = BitmapFactory.decodeFile(selectedImagePath, options);


        imgPhoto.setImageBitmap(bm);
        bitmapToFile(IMAGE_TAG, bm);
    }

    public void bitmapToFile(String filename, Bitmap your_bitmap) {
        try {
            f = new File(ctx.getCacheDir(), filename);
            f.createNewFile();

            Bitmap bitmap = your_bitmap;
            ByteArrayOutputStream bos = new ByteArrayOutputStream();
            bitmap.compress(Bitmap.CompressFormat.JPEG, 100, bos);
            byte[] bitmapdata = bos.toByteArray();


            FileOutputStream fos = null;

            fos = new FileOutputStream(f);
            fos.write(bitmapdata);
            fos.flush();
            fos.close();
            bos.flush();
            bos.close();
        } catch (FileNotFoundException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
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

    public static String[] getStringArray(JSONArray jsonArray) {
        String[] stringArray = null;
        int length = jsonArray.length();
        if (jsonArray != null) {
            stringArray = new String[length];
            for (int i = 0; i < length; i++) {
                stringArray[i] = jsonArray.optString(i);
            }
        }
        return stringArray;
    }

    public static ArrayList<Merchant> getArrayList_Merchant(JSONArray jsonArray) throws JSONException {
        ArrayList<Merchant> stringArray = new ArrayList<Merchant>();
        int length = jsonArray.length();
        if (jsonArray != null) {

            for (int i = 0; i < length; i++) {
                Merchant merchant = new Merchant();
                merchant.setName(jsonArray.getJSONObject(i).getString("name"));
                merchant.setId(jsonArray.getJSONObject(i).getLong("id"));
                stringArray.add(merchant);
            }
        }
        return stringArray;
    }

    public static ArrayList<Devices> getArrayList_Devices(JSONArray jsonArray) throws JSONException {
        ArrayList<Devices> stringArray = new ArrayList<Devices>();
        int length = jsonArray.length();
        if (jsonArray != null) {

            for (int i = 0; i < length; i++) {
                Devices Devices = new Devices();
                Devices.setName(jsonArray.getJSONObject(i).getString("name"));
                Devices.setId(jsonArray.getJSONObject(i).getLong("id"));
                stringArray.add(Devices);
            }
        }
        return stringArray;
    }
}
