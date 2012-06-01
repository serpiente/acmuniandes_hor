package acmuniandes_hor.persist;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;

import acmuniandes_hor.entidades.Curso;
import acmuniandes_hor.entidades.Ocurrencia;

/**
 * Clase que persiste las entidades de Curso dentro de la base de datos.
 * Copyright Capítulo Estudiantil ACM Universidad de los Andes
 * Creado y desarrollado por Capitulo Estudiantil ACM Universidad de los Andes.
 * Liderado por Juan Tejada y Jorge Lopez.
 */
public class JavaDao {

	// --------------
	// Atributos
	// -------------

	/**
	 * Conexión a la base de datos
	 */

	private Connection conn;

	/**
	 * Fabrica de las conexiones
	 */
	private ConnectionManager cm;

	// -----------------
	// Métodos
	// -----------------

	/**
	 * Constructor de la clase
	 */
	public JavaDao() {
		cm = new ConnectionManager();
		conn = cm.getConnection();
	}

	/**
	 * Método que cierra la conexión.
	 */

	public void closeConnection() {
		cm.closeConnection();
	}

	/**
	 * Método que persiste un curso.
	 * 
	 * <pre>
	 * &lt;b&gt;pre:&lt;/b&gt; Se asume que el curso tiene asignado sus valores de forma valida.
	 * &#064;param curso
	 * 
	 */
	public void persistCurso(Curso curso) {
		if (curso.getOcurrencias() != null) {
			String query = "";
			try {
				PreparedStatement st;
				query = "";
				if (curso.getMagistral() != null) {
					query = "INSERT INTO CURSOS VALUES (?,?,?,?,?,?,?,?,?,?,?)";
					st = conn.prepareStatement(query);
					st.setInt(1, Integer.parseInt(curso.getCrn()));
					st.setString(2,curso.getCodigo());
					st.setString(3, curso.getTitulo());
					st.setInt(4, curso.getSeccion());
					st.setDouble(5, (curso.getCreditos()));
					st.setInt(6, curso.getDisponibles());
					st.setInt(7, curso.getInscritos());
					st.setInt(8, curso.getCapacidad());
					st.setString(9, "" +curso.getTipo());
					st.setString(10, curso.getDepartamento());
					st.setInt(11, Integer.parseInt(curso.getMagistral()));
					
				} else {
					query = "INSERT INTO CURSOS (CRN, CODIGO, TITLE, SECCION, CREDITOS, CUPOS_DISPONIBLES, INSCRITOS, CAPACIDAD_TOTAL, TIPO, DEPARTAMENTO) VALUES (?,?,?,?,?,?,?,?,?,?)";
					st = conn.prepareStatement(query);
					st.setInt(1, Integer.parseInt(curso.getCrn()));
					st.setString(2,curso.getCodigo());
					st.setString(3, curso.getTitulo());
					st.setInt(4, curso.getSeccion());
					st.setDouble(5, (curso.getCreditos()));
					st.setInt(6, curso.getDisponibles());
					st.setInt(7, curso.getInscritos());
					st.setInt(8, curso.getCapacidad());
					st.setString(9, "" +curso.getTipo());
					st.setString(10, curso.getDepartamento());
				}
				
				st.execute();
				st.close();
				
				
				SimpleDateFormat sdf1 = new SimpleDateFormat("dd-MM-yy");
				SimpleDateFormat sdf2 = new SimpleDateFormat("yyyy-MM-dd");
				ArrayList<Ocurrencia> arreglo = curso.getOcurrencias();
				for (Ocurrencia ocurrencia : arreglo) {
					
					query = "INSERT INTO OCURRENCIAS (HORA_INICIO,HORA_FIN,DIA, SALON, FECHA_INICIO, FECHA_FIN, CRN_CURSO) VALUES (?,?,?,?,?,?,?)";
					st = conn.prepareStatement(query);
					
					st.setString(1,ocurrencia.getHoraInicio());
					st.setString(2,ocurrencia.getHoraFin());
					st.setString(3, ocurrencia.getDia());
					st.setString(4, ocurrencia.getSalon());
					st.setString(5, sdf2.format(sdf1.parse(arreglarFecha(ocurrencia.getFechaInicial()))));
					st.setString(6, sdf2.format(sdf1.parse(arreglarFecha(ocurrencia.getFechaFinal()))));
					st.setInt(7, Integer.parseInt(curso.getCrn()));

					st.execute();
					st.close();

				}

				ArrayList<String> profesores = curso.getProfesores();
				if (profesores != null) {
					for (String string : profesores) {
						
						query = "INSERT INTO PROFESORES (NOMBRE) VALUES(?)";
						
						
						st = conn.prepareStatement(query);
						st.setString(1, string);
						try {
							st.execute();
						} catch (Exception e) {
							// Puede pasar..
						}
						query = "INSERT INTO PROFESORES_CURSOS VALUES(?,?)";
						st = conn.prepareStatement(query);
						st.setString(1, string);
						st.setInt(2, Integer.parseInt(curso.getCrn()));
						st.execute();
						st.close();
						
					}
				}

			

			} catch (Exception e) {
				// Oh Uh D:
				System.out.println(query);
				e.printStackTrace();
			}
		}
	}

	public void updateCurso(Curso curso) {

		if (curso.getOcurrencias() != null) {

			try {
				String query = "UPDATE CURSOS SET CUPOS_DISPONIBLES="
						+ curso.getDisponibles() + ", INSCRITOS = "
						+ curso.getInscritos() + ",CAPACIDAD_TOTAL="
						+ curso.getCapacidad() + " WHERE CRN = "
						+ curso.getCrn() + "";
				Statement st = conn.createStatement();
				st.execute(query);
				st.close();
			} catch (Exception e) {
				e.printStackTrace();
			}

		}

	}

	/**
	 * Método que ayuda a la conversión de fechas de español a numero.
	 * 
	 * @param fecha
	 *            en representacion dd - (MM,esp) - yyyy return fecha en
	 *            representacion dd - mm(numero) - yyy
	 */

	private String arreglarFecha(String param) {
		String[] partes = param.split("-");
		String dia = partes[0];
		String mes = partes[1];
		String anio = partes[2];

		if (mes.equals("ENE")) {
			mes = "01";
		} else if (mes.equals("FEB")) {
			mes = "02";
		} else if (mes.equals("MAR")) {
			mes = "03";
		} else if (mes.equals("ABR")) {
			mes = "04";
		} else if (mes.equals("MAY"))
			mes = "05";
		else if (mes.equals("JUN"))
			mes = "06";
		else if (mes.equals("JUL"))
			mes = "07";
		else if (mes.equals("AGO"))
			mes = "08";
		else if (mes.equals("SEP"))
			mes = "09";
		else if (mes.equals("OCT"))
			mes = "10";
		else if (mes.equals("NOV"))
			mes = "11";
		else
			mes = "12";

		return dia + "-" + mes + "-" + anio;
	}
}
