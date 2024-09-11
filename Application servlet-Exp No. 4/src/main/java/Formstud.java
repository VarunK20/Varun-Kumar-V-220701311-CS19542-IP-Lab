
import java.io.*;
import java.io.IOException;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/Formstud")
public final class Formstud extends HttpServlet {
	private static final long serialVersionUID = 1L;
    public Formstud() {
        super();
        // TODO Auto-generated constructor stub
    }
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		PrintWriter b = response.getWriter();
		response.setContentType("text/html");
		String reg = request.getParameter("regnumber");
		String name = request.getParameter("username");
		String cy = request.getParameter("year");
		String sem = request.getParameter("sem");
		String ay = request.getParameter("acdyear");
		String subcd = request.getParameter("scode");
		String sname = request.getParameter("sname");
		String dob = request.getParameter("age");
		String gen = request.getParameter("gen");
		
		b.println("<h3>The reg number is:</h3>" + reg);
		b.println("<h3>The name is:</h3>" + name);
		b.println("<h3> Current year of the student is:</h3>" + cy);
		b.println("<h3>Semester is:</h3>" + sem);
		b.println("<h3>Academic year is:</h3>" + ay);
		b.println("<h3>Subject Code is:</h3>" + subcd);
		b.println("<h3>Subject name is:</h3>" + sname);
		b.println("<h3>Date of Birth is:</h3>" + dob);
		b.println("<h3>The gender is:</h3>" + gen );
//		response.getWriter().append("Served at: ").append(request.getContextPath());
	}
//	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
//		// TODO Auto-generated method stub
//
//		doGet(request, response);
//		
//	}
}
