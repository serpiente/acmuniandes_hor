package acmuniandes_hor.dataloader;

import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import java.util.HashMap;
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
import acmuniandes_hor.persist.JavaDao;

public class DataLoader implements Runnable{
	
	private final static String BASE_URL = "http://registroapps.uniandes.edu.co/scripts/adm_con_horario1_joomla.php?depto=";
	
	//For Scraping
	private final static String SELECTOR_QUERY = "font.texto4:not(:has(font),:has(strong)):matches([^ ]),font[color=#FF0000]";
	
	private String departamento;
	//private String codDepartamento;
	private final String URL;
	private JavaDao dao;
	private HashMap<String, String> hm;
	private HashMap<String, String> hmsis;
	
	public DataLoader(String depto, String url){
		this.departamento = depto;
		//this.codDepartamento = codDepto;
		this.URL = url;
		this.dao = new JavaDao();
		this.hm = new HashMap<String, String>();
		this.hmsis = new HashMap<String, String>();
	}
	
	private void scrape() throws ClientProtocolException, IOException{
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
		Document doc = Jsoup.connect(this.URL).get();
		Elements textos = doc.select(SELECTOR_QUERY);
		
		
//		for (Element texto : textos) {
//			System.out.println(texto.text());
//		}
		
		int i = 0;
		while(i < textos.size()) {
			Curso curso = new Curso();
			curso.setCrn(textos.get(i++).text());
			if(hm.get(curso.getCrn()) != null){
				curso.setMagistral(hm.get(curso.getCrn()));
			}			
			curso.setCodigo(textos.get(i++).text());
			if(curso.getCodigo().endsWith("A")){
				curso.setTipo(Curso.A);
			}else if(curso.getCodigo().endsWith("B")){
				curso.setTipo(Curso.B);
			}
			curso.setSeccion(Integer.parseInt(textos.get(i++).text()));
			if(hmsis.get(""+curso.getCodigo()+curso.getSeccion()) != null){
				curso.setMagistral(hmsis.get(""+curso.getCodigo()+curso.getSeccion()));
			}
			curso.setCreditos(Double.parseDouble(textos.get(i++).text()));
			curso.setTitulo(textos.get(i++).text());
			curso.setCapacidad(Integer.parseInt(textos.get(i++).text()));
			curso.setInscritos(Integer.parseInt(textos.get(i++).text()));
			curso.setDisponibles(Integer.parseInt(textos.get(i++).text()));
			if (i<textos.size()) {
				if (!textos.get(i).text().equals("-")&& !textos.get(i).text().isEmpty()) {
					ArrayList<Ocurrencia> ocurrencias = new ArrayList<Ocurrencia>();
					while (i < textos.size() && textos.get(i).text().matches("[LMIJVSD ]+")) {
						curso.setDias(textos.get(i++).text());
						String[] dias = curso.getDias().split(" ");
						String[] horas = textos.get(i++).text().split(" - ");
						if(horas.length==0 || horas.length==1){
							horas = new String[2];
						}
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
			}
			if (i<textos.size()) {
				ArrayList<String> profesores = new ArrayList<String>();
				String profesor = textos.get(i++).text();
				while (!profesor.matches("[0-9]+")) {
					if(profesor.matches("^La .+- -$")){
						String [] compls = profesor.replaceAll(" ", "").split(":")[1].split("-");
						curso.setComplementarias(compls);
						for (int j = 0; j < compls.length; j++) {
							hm.put(compls[j], curso.getCrn());
						}
					} else if(profesor.matches("^Debe .+[0-9]$")){
						String[] sentence = profesor.split(" ");
						hmsis.put(""+sentence[3]+sentence[sentence.length-1], curso.getCrn());
					} else {
						profesores.add(profesor);
					}
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
			curso.setDepartamento(this.departamento);
			dao.persistCurso(curso);
		}
		System.out.println("Duration: "+ (System.currentTimeMillis() - s));
		
	}

	@Override
	public void run() {
		try {
			this.scrape();
		} catch (ClientProtocolException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		
	}

	public String getDepartamento() {
		return departamento;
	}

	public void setDepartamento(String departamento) {
		this.departamento = departamento;
	}

//	public String getCodDepartamento() {
//		return codDepartamento;
//	}
//
//	public void setCodDepartamento(String codDepartamento) {
//		this.codDepartamento = codDepartamento;
//	}
	
}
