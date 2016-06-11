package dao;

import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;

import beans.Produit;


public class ProduitsDao {


	static Date creation = Calendar.getInstance().getTime();
	static Date relance = null;
	static SimpleDateFormat formater = new SimpleDateFormat("dd/MM/yyyy");

	public static ArrayList<Produit> lireProduits () {

		ArrayList<Produit> resultat = new ArrayList<Produit>();
		Produit asked;

		String url = "jdbc:mysql://localhost:8889/gestion_site";
		String login = "root";
		String passwd = "root";
		java.sql.Connection cn = null;

		try {
			Class.forName("com.mysql.jdbc.Driver").newInstance();
			cn = DriverManager.getConnection(url, login, passwd);
			Statement st1 = (Statement) cn.createStatement();
			String sql = "SELECT * FROM produit;";
			ResultSet resultat1 = (ResultSet) st1.executeQuery(sql);
			while (resultat1.next()) {
				System.out.println(resultat1.getString(1));
				System.out.println(resultat1.getString(2));
				System.out.println(resultat1.getString(3));
				System.out.println(resultat1.getString(4));
				System.out.println(resultat1.getString(5));
				System.out.println(resultat1.getString(6));
				System.out.println(resultat1.getString(7));
				System.out.println(resultat1.getString(8));
				System.out.println(resultat1.getString(9));
				System.out.println(resultat1.getString(10));
				System.out.println(resultat1.getString(11));

				asked = new Produit(resultat1.getString(1), resultat1.getString(2), resultat1.getString(3), 
						resultat1.getString(4), resultat1.getString(5), resultat1.getString(6), 
						resultat1.getString(7), resultat1.getString(8), resultat1.getString(9),
						resultat1.getString(10), Integer.parseInt(resultat1.getString(11)) );
				resultat.add(asked);
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (InstantiationException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (IllegalAccessException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		//System.out.println(resultat);
		return resultat;

	}

}

