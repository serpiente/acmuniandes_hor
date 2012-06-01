package acmuniandes_hor.dataloader;

import java.io.IOException;
import org.apache.http.client.ClientProtocolException;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import acmuniandes_hor.entidades.Curso;
import acmuniandes_hor.persist.JavaDao;
/**
* Copyright Capítulo Estudiantil ACM Universidad de los Andes
* Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes.
* Liderado por Juan Tejada y Jorge Lopez.
**/
public class DataUpdater implements Runnable{

	private final static String BASE_URL = "http://registroapps.uniandes.edu.co/scripts/adm_con_horario1_joomla.php?depto=";
	
	//For Scraping
	private final static String SELECTOR_QUERY = "td[width=39] > font.texto4,td[width=69] > font.texto4,td[width=57] > font.texto4,td[width=77] > font.texto4";
	
	private final String URL;
	private JavaDao dao;
	
	
	public DataUpdater(String url, JavaDao dao){
		this.URL = url;
		this.dao = dao;
	}
	
	private void scrape() throws ClientProtocolException, IOException{
		
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
			curso.setCapacidad(Integer.parseInt(textos.get(i++).text()));
			curso.setInscritos(Integer.parseInt(textos.get(i++).text()));
			curso.setDisponibles(Integer.parseInt(textos.get(i++).text()));
			dao.updateCurso(curso);
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

}
