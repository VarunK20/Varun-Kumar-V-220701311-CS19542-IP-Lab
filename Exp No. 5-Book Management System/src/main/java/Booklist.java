import java.io.*;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.sql.*;

@WebServlet("/Booklist")
public class Booklist extends HttpServlet {
    private static final long serialVersionUID = 1L;

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        Connection conn = null;
        Statement stmt = null;
        ResultSet rs = null;

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            conn = DriverManager.getConnection("jdbc:mysql://localhost:3307/books", "root", "");
            String sql = "SELECT * FROM book";
            stmt = conn.createStatement();
            rs = stmt.executeQuery(sql);

            out.println("<h2>Book List</h2>");
            out.println("<table border='1'><tr><th>Book ID</th><th>Book Name</th><th>Edition</th><th>Price</th></tr>");

            // Iterate through the result set and display the books
            while (rs.next()) {
                out.println("<tr><td>" + rs.getString("book_id") + "</td><td>" + rs.getString("book_name") + "</td><td>" + rs.getString("book_edition") + "</td><td>" + rs.getString("book_price") + "</td></tr>");
            }
            out.println("</table>");
        } catch (Exception e) {
            e.printStackTrace();
            out.println("Error: " + e.getMessage());
        } finally {
            try {
                if (rs != null) rs.close();
                if (stmt != null) stmt.close();
                if (conn != null) conn.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        doGet(request, response);
    }
}

