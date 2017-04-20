package com.barclays.report.models;

/**
 * Created by francis on 18/03/2016.
 */
public class Branch {
    public long id;
    public String name;

    public Branch(long id, String name) {
        this.id = id;
        this.name = name;
    }

    public Branch() {
    }

    public long getId() {
        return id;
    }

    public void setId(long id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }
}
