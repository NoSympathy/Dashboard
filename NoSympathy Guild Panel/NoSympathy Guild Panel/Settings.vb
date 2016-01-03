Public Class Settings

    Private Sub Settings_Load(sender As Object, e As EventArgs) Handles MyBase.Load
        TextBox1.Text = My.Settings.APIKey
        If TextBox1.Text.Trim() = "" Then
            CopyButton.Hide()
            MessageBox.Show("please enter your API key")
        End If
        TextBox1.ReadOnly = False
    End Sub

    Private Sub ANetMyAccountAPI_LinkClicked(sender As Object, e As LinkLabelLinkClickedEventArgs) Handles ANetMyAccountAPI.LinkClicked
        Process.Start("https://account.arena.net/applications")
    End Sub

    Private Sub DeleteKeyBtn_Click(sender As Object, e As EventArgs) Handles DeleteKeyBtn.Click
        MessageBox.Show("Well, eat a Hotdog then punk!") ' For funzies
        TextBox1.Text = ""
        TextBox1.ReadOnly = False
        CopyButton.Hide()
        My.Settings.APIKey = TextBox1.Text
        My.Settings.Save()
        My.Settings.Reload()
    End Sub

    Private Sub Button1_Click(sender As Object, e As EventArgs) Handles Button1.Click
        My.Settings.APIKey = TextBox1.Text
        TextBox1.ReadOnly = True
        My.Settings.Save()
        CopyButton.Show()


        MsgBox("API Key Saved! Thank you for flying with AiRNoS, Have a Taco, Bye Bye Now!", MsgBoxStyle.Information)
    End Sub

    Private Sub CopyButton_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles CopyButton.Click
        'Checks to see if the user selected anything
        If TextBox1.SelectedText <> My.Settings.APIKey Then
            'Copy the information to the clipboard
            Clipboard.SetText(My.Settings.APIKey)
            MsgBox("Copied!", MsgBoxStyle.Exclamation)
        Else
            'If no text was selected, print out an error message box
            MsgBox("No text Is selected To copy", MsgBoxStyle.Information)
        End If
    End Sub

    Private Sub Button2_Click(sender As Object, e As EventArgs) Handles Button2.Click
        Me.Close()
    End Sub



End Class