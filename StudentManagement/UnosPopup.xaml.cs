using System;
using System.Windows;
using MySql.Data.MySqlClient;

namespace StudentManagement
{
    public partial class UnosPopup : Window
    {
        public UnosPopup()
        {
            InitializeComponent();
        }

        private void Save_Click(object sender, RoutedEventArgs e)
        {
            if (string.IsNullOrEmpty(idTextBox.Text) || string.IsNullOrEmpty(imeTextBox.Text) || string.IsNullOrEmpty(prezimeTextBox.Text) || string.IsNullOrEmpty(adresaTextBox.Text) || string.IsNullOrEmpty(gradTextBox.Text))
            {
                MessageBox.Show("Molimo popunite sva polja.");
            }
            else
            {
                string connectionString = "Server=localhost;Database=crud_baza;Uid=root;Pwd=prekucatcuovo";
                MySqlConnection connection = new MySqlConnection(connectionString);

                try
                {
                    connection.Open();
                    string query = "SELECT * FROM student WHERE ID = @ID";
                    MySqlCommand cmd = new MySqlCommand(query, connection);
                    cmd.Parameters.AddWithValue("@ID", idTextBox.Text);
                    MySqlDataReader reader = cmd.ExecuteReader();

                    if (reader.HasRows)
                    {
                        MessageBox.Show("Osoba s unesenim ID već postoji.");
                    }
                    else
                    {
                        reader.Close();
                        string insertQuery = "INSERT INTO student (ID, Ime, Prezime, Adresa, Grad) VALUES (@ID, @Ime, @Prezime, @Adresa, @Grad)";
                        MySqlCommand insertCommand = new MySqlCommand(insertQuery, connection);
                        insertCommand.Parameters.AddWithValue("@ID", idTextBox.Text);
                        insertCommand.Parameters.AddWithValue("@Ime", imeTextBox.Text);
                        insertCommand.Parameters.AddWithValue("@Prezime", prezimeTextBox.Text);
                        insertCommand.Parameters.AddWithValue("@Adresa", adresaTextBox.Text);
                        insertCommand.Parameters.AddWithValue("@Grad", gradTextBox.Text);
                        insertCommand.ExecuteNonQuery();

                        MessageBox.Show("Podaci uspješno uneseni.");
                        this.Close();
                    }
                }
                catch (Exception ex)
                {
                    MessageBox.Show(ex.Message);
                }
                finally
                {
                    connection.Close();
                }
            }
        }
    }
}
