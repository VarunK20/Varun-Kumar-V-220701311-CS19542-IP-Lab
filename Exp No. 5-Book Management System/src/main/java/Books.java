import java.io.*;
import java.sql.*;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/Books")
public class Books extends HttpServlet {
	private static final long serialVersionUID = 1L;
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		response.getWriter().append("Served at: ").append(request.getContextPath());
	}

	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		response.setContentType("text/html");
		PrintWriter out = response.getWriter();
		
		String bookID = request.getParameter("bookid");
		String bookName = request.getParameter("bookName");
		String bookEdition = request.getParameter("bookEdition");
		String bookPrice = request.getParameter("bookPrice");

		System.out.println("Book ID: " + bookID);
		System.out.println("Book Name: " + bookName);
		System.out.println("Book Edition: " + bookEdition);
		System.out.println("Book Price: " + bookPrice);

		PreparedStatement pstmt = null;
		Connection conn = null;
		try {
			Class.forName("com.mysql.cj.jdbc.Driver");
			conn = DriverManager.getConnection("jdbc:mysql://localhost:3307/books", "root", "");
            String sql = "INSERT INTO book (book_id, book_name, book_edition, book_price) VALUES (?, ?, ?, ?)";
            pstmt = conn.prepareStatement(sql);
            
            pstmt.setString(1,bookID);
            pstmt.setString(2, bookName);
            pstmt.setString(3,  bookEdition);
            pstmt.setString(4,  bookPrice);
            
            int row = pstmt.executeUpdate();
            if(row != 0) {
            	out.println("Book is Registered successfully!!!");
            	out.println("<a href=\"home.html\">Go to Home</a>");
            } else {
            	out.println("Failed to register Book.");
            	out.println("<a href=\"home.html\">Go to Home</a>");
            }
		} catch (Exception e) {
			e.printStackTrace();
			out.println("Error: " + e.getMessage());
		} finally {
			try {
				if (pstmt != null) pstmt.close();
				if(conn != null) conn.close();
			} catch (SQLException e){
				e.printStackTrace();
			}
		}
	}
}
