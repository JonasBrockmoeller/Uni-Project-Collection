/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package com.mycompany.adapter_pattern;

/**
 *
 * @author jonasbrockmoller
 */
public class WildTurkey implements Turkey {

    @Override
    public void gobble() {
        System.out.println("Wild turkey gobbles");
    }

    @Override
    public void fly() {
        System.out.println("Wild turkey flies");
    }

}
