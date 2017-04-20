package com.barclays.report.global;

import android.content.Context;
import android.graphics.Typeface;
import android.view.ViewGroup;
import android.widget.TextView;

public class Fonting {
	private static Typeface typeface;
	public static int KEY_LIGHT = 0;
	public static int KEY_REGULAR = 1;
	public static int KEY_CONDENSED = 2;
	public static int KEY_CONDENSED_LIGHT = 3;
	public static int KEY_CONDENSED_REGULAR = 4;

	public static Typeface getFont(Context ctx, int key) {
		if (key == 0) {
			typeface = Typeface.createFromAsset(ctx.getAssets(),
					"fonts/Roboto-Light.ttf");
		} else if (key == 1) {
			typeface = Typeface.createFromAsset(ctx.getAssets(),
					"fonts/Roboto-Regular.ttf");
		}else if(key==2){
			typeface = Typeface.createFromAsset(ctx.getAssets(),
					"fonts/Roboto-Condensed.ttf");
		}else if(key==3){
			typeface = Typeface.createFromAsset(ctx.getAssets(),
					"fonts/RobotoCondensed-Light.ttf");
		}else if(key==4){
			typeface = Typeface.createFromAsset(ctx.getAssets(),
					"fonts/RobotoCondensed-Regular.ttf");
		}

		return typeface;

	}

	public static void setTypeFaceForViewGroup(ViewGroup vg, Context ctx,
			int key) {

		for (int i = 0; i < vg.getChildCount(); i++) {

			if (vg.getChildAt(i) instanceof ViewGroup)
				setTypeFaceForViewGroup((ViewGroup) vg.getChildAt(i), ctx, key);

			else if (vg.getChildAt(i) instanceof TextView)
				((TextView) vg.getChildAt(i)).setTypeface(getFont(ctx, key));

		}

	}

	
	
}
