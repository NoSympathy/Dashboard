Imports System.Configuration
Imports NoSympathy_Guild_Panel.My

Public Class Settings
    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        Me.Close()
    End Sub

    Private Sub Label1_Click(sender As Object, e As EventArgs) Handles Label1.Click

    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        My.Settings.APIKey = TextBox1.Text
        My.Settings.Save()
    End Sub

    Private Sub Settings_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        TextBox1.Text = My.Settings.APIKey
        If TextBox1.Text.Trim() = "" Then
            MessageBox.Show("please enter your API key")
        End If
    End Sub
End Class