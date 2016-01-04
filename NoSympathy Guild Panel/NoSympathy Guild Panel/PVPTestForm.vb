Imports Models
Imports Newtonsoft.Json

Public Class PVPTestForm
    Private Sub TextBox1_Click(sender As Object, e As EventArgs) Handles TextBox1.Click
        TextBox1.Text = ""
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        Dim pvp As Models.PVP
        Dim json As String
        'json = 

        Dim P = pvp.aggregate

        'CharacterBindingSource.DataSource = Characters
        DataGridView1.DataSource = P
        RichTextBox1.Text = json

    End Sub

    Private Sub LinkLabel1_LinkClicked(sender As Object, e As LinkLabelLinkClickedEventArgs) Handles LinkLabel1.LinkClicked
        Personal_Web.Show()
    End Sub

End Class