package acmuniandes_hor.dataloader;

import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.Iterator;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import acmuniandes_hor.entidades.Curso;
import acmuniandes_hor.entidades.Ocurrencia;

public class DataLoader {
	
	
	public static void main(String[] args) throws ClientProtocolException, IOException{
//		HttpClient httpclient = new DefaultHttpClient();
//		HttpGet httpget = new HttpGet("http://registroapps.uniandes.edu.co/scripts/adm_con_horario1_joomla.php?depto=ADMI&nombreDepto=Administraci%F3n%20de%20Empresas");
//		HttpResponse response = httpclient.execute(httpget);
//		HttpEntity entity = response.getEntity();
//		if (entity != null) {
//			System.out.println("here");
//			System.out.println(EntityUtils.toString(entity));
//			Document doc = Jsoup.parse(EntityUtils.toString(entity));
//			
//			Elements texts = doc.select("font");
//			
//			Iterator<Element> ite = texts.iterator();
//			
//			while(ite.hasNext()){
//				Element el = ite.next();
//				System.out.println(el.text());
//			}
//		}
		long s = System.currentTimeMillis();
		Document doc = Jsoup.connect("http://registroapps.uniandes.edu.co/scripts/adm_con_horario1_joomla.php?depto=IELE").get();
		Elements textos = doc.select("font.texto4:not(:has(font)):matches([^ ]):not(:has(strong)");
//		System.out.println(textos.size());
//		System.out.println(textos.get(textos.size()-1).text());
//		for (Element texto : textos) {
//			System.out.println(texto.text());
//		}
		
//		ArrayList<Curso> cursosADMI = new ArrayList<Curso>();
		int i = 0;
		while(i < textos.size()) {
			Curso curso = new Curso();
			curso.setCrn(textos.get(i++).text());
			curso.setCodigo(textos.get(i++).text());
			curso.setSeccion(Integer.parseInt(textos.get(i++).text()));
			curso.setCreditos(Double.parseDouble(textos.get(i++).text()));
			curso.setTitulo(textos.get(i++).text());
			curso.setCapacidad(Integer.parseInt(textos.get(i++).text()));
			curso.setInscritos(Integer.parseInt(textos.get(i++).text()));
			curso.setDisponibles(Integer.parseInt(textos.get(i++).text()));
			if(!textos.get(i).text().equals("-") && !textos.get(i).text().isEmpty()){
				ArrayList<Ocurrencia> ocurrencias = new ArrayList<Ocurrencia>();
				while (i<textos.size() && textos.get(i).text().matches("[LMIJVSD ]+")) {
					curso.setDias(textos.get(i++).text());
					String[] dias = curso.getDias().split(" ");
					String[] horas = textos.get(i++).text().split(" - ");
					String salon = textos.get(i++).text();
					String fechain = textos.get(i++).text();
					String fechafin = textos.get(i++).text();
					for (int j = 0; j < dias.length; j++) {
						Ocurrencia ocur = new Ocurrencia();
						ocur.setDia(dias[j]);
						ocur.setHoraInicio(horas[0]);
						ocur.setHoraFin(horas[1]);
						ocur.setSalon(salon);
						ocur.setFechaInicial(fechain);
						ocur.setFechaFinal(fechafin);
						ocurrencias.add(ocur);
					}
				}
				curso.setOcurrencias(ocurrencias);
			} else {
				i++;
				i++;
				i++;
				i++;
			}
			
			if (i<textos.size()) {
				ArrayList<String> profesores = new ArrayList<String>();
				String profesor = textos.get(i++).text();
				while (!profesor.matches("[0-9]+")) {
					profesores.add(profesor);
					if (i < textos.size()) {
						profesor = textos.get(i++).text();
					} else {
						profesor = "00000";
						i++;
					}
				}
				i--;
				curso.setProfesores(profesores);
			}
			curso.setDepartamento("Administracion");
			System.out.println(curso.toString());
//			cursosADMI.add(curso);
		}
		System.out.println("Duration: "+ (System.currentTimeMillis() - s));
		
//		for (Curso curso : cursosADMI) {
//			System.out.println(curso.toString());
//		}
		
//		System.out.println(textos.text());
		
	}
	
}
